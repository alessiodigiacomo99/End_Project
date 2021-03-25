<template>
 
    <div>
        <header id="header_show">
            <navbarsearch-component></navbarsearch-component>
        </header>

        <main id="main_show">

            <section class="banner_show">
                <div class="show_img_restaurant">
                    <img :src="'http://localhost:8888/storage/app/public/' + restaurant.cover " alt="">
                    <div class="title_show">
                        <h1>{{ restaurant.name }}</h1>
                    </div>
                </div>
            </section>

            <section class="show_restaurant">
                <!-- info ristorante -->
                <div class="info_restaurant">
                    <div class="types_restaurant">
                        <span  v-for="type in  restaurant.types" class="name"> {{ type.name }} <span class="divisore">&bull;</span> </span>
                    </div>
                    <div class="address_restaurant">
                        <span> {{ restaurant.address }} </span> <span> {{ restaurant.city }} </span>
                    </div>
                </div>
                <!-- /info ristorante -->
                
                <div class="dishes_carello" v-if="active == true">
                    <!-- piatti -->
                    <div class="dishes col-lg-10">
                        <div class="dish_container col-lg-4" v-for="(dish, index) in restaurant.dishes">
                            <div class="dish" @click="addCart(index)" >
                                <div class="info_add_dish" >
                                    <div class="info_dish">
                                        <div class="name">{{ dish.name }}</div>
                                        <div>{{ dish.ingredients }}</div>
                                        <div>{{ dish.price }} &euro;</div>
                                    </div>
                                </div>
                                <div class="img_dish">
                                    <img :src="'http://localhost:8888/storage/app/public/' + dish.cover " alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /piatti -->
                    <!-- carrello -->
                    <aside class="col-lg-2">
                        <div class="carello">
                            <div class="carello_order" v-for="(dish, index) in cart">
                                <div class="dishes_order">
                                    <div class="dish_name"> {{dish.name}} </div>
                                    <!-- <span>({{dish.quantity}})</span> -->
                                    <div class="dish_price"> {{dish.price}} &euro;</div>
                                </div>
                                <div class="btn_remouve">
                                    <button @click="removeCart(index)">-</button>
                                </div>
                            </div>
                            <div class="total_order">
                                <div  v-if="totalPrice > 0" >
                                    <div class="total">TOTALE : {{totalPrice}} &euro;</div>
                                    <button @click="active = false">Pagamento</button>
                                </div>
                                <div v-else>Il carrello è Vuoto</div>
                            </div>
                        </div>
                    </aside>
                    <!-- /carrello -->
                </div>

            </section>

            <section class="show_restaurant"  v-if="active == false">

                <div>
                    <aside class="col-md-12">
                        <div class="carello">
                            <div class="carello_order" v-for="(dish, index) in cart">
                                <div class="dishes_order">
                                    <div class="dish_name"> {{dish.name}} </div>
                                    <!-- <span>({{dish.quantity}})</span> -->
                                    <div class="dish_price"> {{dish.price}} &euro;</div>
                                </div>
                                <div class="btn_remouve">
                                    <button @click="removeCart(index)">-</button>
                                </div>
                            </div>
                            <div class="total_order">
                                <div  v-if="totalPrice > 0" >
                                    <div class="total">TOTALE : {{totalPrice}} &euro;</div>
                                    <button @click="active = true">Torna Indietro</button>
                                </div>
                                <div v-else>Il carrello è vuoto</div>
                            </div>
                        </div>
                    </aside>
            
                    <div>
                        <form @submit.prevent="orderCreate()" method="POST" action="/api">
                            <label for="">Price</label>
                            <div name="total_price">{{totalPrice}}</div>
                            <label for="">Name</label>
                            <input type="text" name="customer_name" v-model="customer_name">
                            <label for="">Surname</label>
                            <input type="text" name="customer_surname" v-model="customer_surname">
                            <label for="">Phone</label>
                            <input type="text" name="customer_phone" v-model="customer_phone">
                            <label for="">City</label>
                            <input type="text" name="customer_city" v-model="customer_city">
                            <label for="">Address</label>
                            <input type="text" name="customer_address" v-model="customer_address">
                            <label for="">CAP</label>
                            <input type="text" name="customer_CAP" v-model="customer_CAP">
            
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                </div>
                <div>pippo</div>
            </section>
        </main>

        <footer-component></footer-component>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                id:this.$route.params.id,
                restaurant: "",
                totalPrice: 0,
                cart: [],
                price: "",
                customer_name: "",
                customer_surname: "",
                customer_phone: "",
                customer_city: "",
                customer_address: "",
                customer_CAP: "",
                active: true
            }
        },
        methods: {
            addCart(index) {
                let counter = 1;
                for (let i = 0; i < this.cart.length; i++) {
                    
                    if(this.restaurant.dishes[index].id == this.cart[i].id){
                        counter++
                    } 
                    this.restaurant.dishes[index].quantity = counter;
                }
                this.cart.push({
                    id : this.restaurant.dishes[index].id,
                    name: this.restaurant.dishes[index].name,
                    ingredients: this.restaurant.dishes[index].ingredients,
                    price: this.restaurant.dishes[index].price,
                    quantity: counter
                });
                localStorage.setItem('cart', JSON.stringify(this.cart));
            },
            removeCart(index) {
                this.cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(this.cart));
                // console.log(cart);
            },
            orderCreate(){
                axios.post('/api/orders',{
                    total_price: this.totalPrice,
                    customer_name: this.customer_name,
                    customer_surname: this.customer_surname,
                    customer_phone: this.customer_phone,
                    customer_city: this.customer_city,
                    customer_address: this.customer_address,
                    customer_CAP: this.customer_CAP
                })
                .then(response => {
                    $('#success').html(response.data.message)
                }).catch(error => {
                    console.log(error); 
                });
            }
        },
        updated() {
            let totalPrice = 0;
            this.cart.forEach(element => {
                totalPrice += element.price;
            });
            this.totalPrice = totalPrice;
            localStorage.setItem('totalPrice', JSON.stringify(this.totalPrice));
        },
        mounted() {
                this.cart = JSON.parse(localStorage.getItem("cart")) || [];
            // console.log(localStorage);
        },
        beforeDestroy () {
            localStorage.removeItem('cart');
        },
        created(){
            axios.get('/api/restaurants/' + this.id)
            .then(response => {
                this.restaurant = response.data;
                // console.log(this.restaurant);
            }).catch(error => {
                console.log(error); 
            });
        },
        
    }
</script>

<style>
    .visible {
        visibility: 1;
    }
    .notvisible {
        visibility: 0;
    }
    .font{
        font-size: 5em;
    }
</style>