<template>
    <div>
        <modal :show="showModal" @close="showModal = false" :title="'Påmelding ' + title">
            <div style="padding: 40px;">
                <el-form label-position="top" :model="form">

                    <section class="step rooms">
                        <el-row>
                            <el-form-item label="enkeltrom" style="text-align: center;">
                                {{ prices.single }},- per person
                                <div class="flex-center">
                                    <el-input-number
                                        v-model="form.amountSingle"
                                        @change="onSingleChange"
                                        :min="0"
                                        :max="10"
                                    ></el-input-number>
                                </div>
                            </el-form-item>

                            <div v-for="room in form.rooms.single">
                                <el-card class="box-card" style="box-shadow: 0;">
                                    <div slot="header" style="display: flex; align-items: stretch;">
                                        <div style="flex: 1;" v-text="'rom ' + room.num"></div>

                                        <!-- <el-button type="default" @click.stop="">
                                            [+] legg til barneseng
                                            +barneseng
                                        </el-button> -->
                                        <el-form-item>
                                            <el-select v-model="child" placeholder="+barneseng">
                                                <el-option :key="0" :label="0" :value="0"></el-option>
                                                <el-option :key="1" :label="1" :value="1"></el-option>
                                                <el-option :key="2" :label="2" :value="2"></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <div class="text item">
                                        <el-row>
                                            <el-col :span="12">
                                                <el-form-item label="navn">
                                                    <el-input></el-input>
                                                </el-form-item>

                                                <el-form-item label="fødselsdato">
                                                    <el-input></el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </div>
                                </el-card>
                            </div>
                        </el-row>

                        <el-row style="text-align: center;">
                            <el-form-item label="dobbeltrom">
                                {{ prices.double }},- per person
                                <div class="flex-center">
                                    <el-input-number
                                        v-model="form.amountDouble"
                                        @change="onDoubleChange"
                                        :min="0"
                                        :max="10"
                                    ></el-input-number>
                                </div>
                            </el-form-item>

                            <div v-for="(room, index) in form.rooms.double">
                                <el-form-item :label="index % 2 === 0 ? 'rom ' + room.num : ''">
                                    <el-input></el-input>
                                </el-form-item>
                            </div>
                        </el-row>

                        <el-row style="text-align: center;">
                            <el-form-item label="twintrom">
                                {{ prices.twin }},- per person
                                <div class="flex-center">
                                    <el-input-number
                                        v-model="form.amountTwin"
                                        @change="onTwinChange"
                                        :min="0"
                                        :max="10"
                                    ></el-input-number>
                                </div>
                            </el-form-item>

                            <div v-for="(room, index) in form.rooms.twin">
                                <el-form-item :label="index % 2 === 0 ? 'rom ' + room.num : ''">
                                    <el-input></el-input>
                                </el-form-item>
                            </div>
                        </el-row>
                    </section>

                    <section class="step orderer">
                        <el-row>
                            <el-form-item label="Navn">
                                <el-input v-model="form.name"></el-input>
                            </el-form-item>

                            <el-form-item label="E-post">
                                <el-input v-model="form.mail"></el-input>
                            </el-form-item>

                            <el-form-item label="Telefon">
                                <el-input v-model="form.phone"></el-input>
                            </el-form-item>

                            <el-form-item label="Adresse">
                                <el-input v-model="form.address"></el-input>
                            </el-form-item>

                            <el-form-item label="Postnr">
                                <el-input v-model="form.postalcode"></el-input>
                            </el-form-item>

                            <el-form-item label="Poststed">
                                <el-input v-model="form.city"></el-input>
                            </el-form-item>

                            <el-form-item label="Tilleggsinfomasjon">
                                <p style="margin: 0; padding: 2px; font-size: 12px; color: #aaa;">Noe du ønsker å tilføye?</p>
                                <el-input v-model="form.extra" type="textarea" :autosize="{minRows: 2}"></el-input>
                            </el-form-item>

                            <el-form-item label="Ønsket avreisested">
                                <el-radio-group v-model="form.departure">
                                    <el-radio-button label="Gjøvik"></el-radio-button>
                                    <el-radio-button label="Hunndalen"></el-radio-button>
                                    <el-radio-button label="Raufoss"></el-radio-button>
                                    <el-radio-button label="Reinsvoll"></el-radio-button>
                                    <el-radio-button label="Eina"></el-radio-button>
                                    <el-radio-button label="Gran"></el-radio-button>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                    </section>

                    <section class="step activities">
                        <div v-show="form.activities.length">
                            <h3>Ekstra Aktiviteter</h3>
                        </div>

                        <div v-for="(activity, index) in form.activities">
                            <el-row>
                                <h4>{{ activity.title }}</h4>
                            </el-row>
                            
                            <el-row>
                                <el-col :span="8">
                                    <label class="el-form-item__label">
                                        Voksne
                                    </label>
                                </el-col>
                                <el-col :span="8">
                                    <label class="el-form-item__label">
                                        Pris {{ activity.price }},-
                                    </label>
                                </el-col>
                                <el-col :span="8" style="display: flex;">
                                    <div @click="increment('adults', 'decrease', index)">
                                        <i class="el-icon-minus"></i>
                                    </div>
                                    <input v-model.number="activity.amountAdults" type="text">
                                    <div @click="increment('adults', 'increase', index)">
                                        <i class="el-icon-plus"></i>
                                    </div>
                                </el-col>
                            </el-row>

                            <el-row>
                                <el-col :span="8">
                                    <label class="el-form-item__label">
                                        Barn (4-12 år)
                                    </label>
                                </el-col>
                                <el-col :span="8">
                                    <label class="el-form-item__label">
                                        Pris {{ activity.priceAfterDiscount }},-
                                    </label>
                                </el-col>
                                <el-col :span="8" style="display: flex;">
                                    <div @click="increment('children', 'decrease', index)">
                                        <i class="el-icon-minus"></i>
                                    </div>
                                    <input v-model.number="activity.amountChildren" type="text">
                                    <div @click="increment('children', 'increase', index)">
                                        <i class="el-icon-plus"></i>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                    </section>

                </el-form>
            </div>

            <div slot="footer">
                <div class="space-between">
                    <span class="total-price">
                        {{ totalPrice }},-
                    </span>

                    <el-button type="success" :disabled="form.name == ''">
                        Send <i class="fa fa-paper-plane" aria-hidden="true" style="margin-left: 5px;"></i>
                    </el-button>
                </div>
            </div>
        </modal>

        <button class="enrolment__button" @click="showModal = true">
            Påmelding
        </button>
    </div>
</template>

<script>
    import trip from '../data'
    import modal from './utils/Modal'

    export default {
        data() {
            return {
                showModal: false,
                finished: false,

                title: trip.title,
                child: 0,

                form: {
                    amountSingle: 0,
                    amountDouble: 0,
                    amountTwin: 0,
                    
                    rooms: {
                        single: [],
                        double: [],
                        twin: []
                    },

                    name: '',
                    mail: '',
                    phone: '',
                    address: '',
                    postalcode: '',
                    city: '',
                    extra: '',
                    departure: 'Gjøvik',

                    activities: []
                },

                /*  */
                prices: {
                    single: 0,
                    double: 0,
                    twin: 0
                }
            }
        },

        components: {
            modal
        },

        computed: {
            /**
             * Total price for the trip.
             */
            totalPrice() {
                return this.roomsPrice + this.activitiesPrice
            },
            
            /**
             * Total price of all rooms.
             */
            roomsPrice() {
                return (this.prices.single * this.form.amountSingle) +
                       (this.prices.double * this.form.amountDouble) +
                       (this.prices.twin   * this.form.amountTwin)
            },

            /**
             * Total price of all selected activties.
             */
            activitiesPrice() {
                //return 0 if the trip does not have any extra activities
                if (!this.form.activities) {
                    return 0
                }

                //calculate the total price
                return this.form.activities.reduce(function(total, value) {
                    return total + Number(
                        (value.price * value.amountAdults) + (value.priceAfterDiscount * value.amountChildren)
                    )
                }, 0)
            }
        },

        methods: {
            onSingleChange(numRooms) {
                /* get the difference between the current number of rooms and the newly selected amount */
                let amountAdded = (numRooms - this.form.amountSingle)

                /* if the number is positive = rooms have been added */
                if (amountAdded > 0) {
                    for (let i = 1; i <= amountAdded; i++) {
                        this.form.rooms.single.push(
                            {num: this.form.amountSingle + i, name: '', dob: ''}
                        )
                    }
                }

                /* if the number is negative = rooms have beeen removed */
                if (amountAdded < 0) {
                    for (let i = 0; i < Math.abs(amountAdded); i++) {
                        this.form.rooms.single.splice(-1, 1)
                    }
                }

                /* update the number of rooms */
                this.form.amountSingle = numRooms
            },

            onDoubleChange(numRooms) {
                /* get the difference between the current number of rooms and the newly selected amount */
                let amountAdded = (numRooms - this.form.amountDouble)

                /* if the number is positive */
                if (amountAdded > 0) {
                    for (let i = 1; i <= amountAdded; i++) {
                        this.form.rooms.double.push(
                            {num: this.form.amountDouble + i, name: '', dob: ''},
                            {num: this.form.amountDouble + i, name: '', dob: ''}
                        )
                    }
                }

                /* if the number is negative */
                if (amountAdded < 0) {
                    for (let i = 0; i < Math.abs(amountAdded); i++) {
                        this.form.rooms.double.splice(-2, 2)
                    }
                }

                /* update the number of rooms */
                this.form.amountDouble = numRooms
            },

            onTwinChange(numRooms) {
                /* get the difference between the current number of rooms and the newly selected amount */
                let amountAdded = (numRooms - this.form.amountTwin)
                
                /* if the number is positive = rooms have been added */
                if (amountAdded > 0) {
                    for (let i = 1; i <= amountAdded; i++) {
                        this.form.rooms.twin.push(
                            {num: this.form.amountTwin + i, name: '', dob: ''},
                            {num: this.form.amountTwin + i, name: '', dob: ''}
                        )
                    }
                }

                /* if the number is negative */
                if (amountAdded < 0) {
                    for (let i = 0; i < Math.abs(amountAdded); i++) {
                        this.form.rooms.twin.splice(-2, 2)
                    }
                }

                /* update the number of rooms */
                this.form.amountTwin = numRooms
            },

            /**
             * 
             */
             increment(age, action, index) {
                if (age == 'children') {
                    if (action == 'increase') {
                        this.form.activities[index].amountChildren++
                    }

                    if (action == 'decrease') {
                        if (this.form.activities[index].amountChildren > 0) {
                            this.form.activities[index].amountChildren--
                        }
                    }
                }

                if (age == 'adults') {
                    if (action == 'increase') {
                        this.form.activities[index].amountAdults++
                    }

                    if (action == 'decrease') {
                        /* do not decrease below zero */
                        if (this.form.activities[index].amountAdults > 0) {
                            this.form.activities[index].amountAdults--
                        }
                    }
                }
            }
        },

        /**
         * Fetch the trip data and assign it to vue props.
         * Create some additional activities props with the 
         * price calculated if there is any discounts.
         */
        mounted() {
            this.prices.single = trip.prices.single
            this.prices.double = trip.prices.double
            this.prices.twin = trip.prices.twin

            this.form.activities = trip.activities

            /* calculate and set initial prices now that activites has been loaded from the server */
            this.form.activities.forEach(function(activity) {
                Vue.set(activity, 'priceAfterDiscount', activity.price - (activity.discountChildren * activity.price / 100))
                Vue.set(activity, 'amountAdults', 0)
                Vue.set(activity, 'amountChildren', 0)
            })
        }
    }
</script>

<style scoped>
    .flex-center {
        display: flex;
        justify-content: center;
    }

    .step {
        margin-bottom: 20px;
    }

    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-price {
        font-size: 1.4em;
    }

    .enrolment__button {
        padding: 10px 15px;
        border: 0;
        background: #FFCA2D;
        border-radius: 2px;
        cursor: pointer;
        font-weight: 800;
        font-size: 1em;
    }
</style>