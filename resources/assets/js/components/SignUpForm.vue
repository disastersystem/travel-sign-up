<template>
    <div>  
        <modal :show="showModal" @close="showModal = false" title="Påmelding">
            <div style="padding: 40px;">
                <el-form label-position="top" :model="form">

                    <section class="step rooms">
                        <el-row>
                            <el-col :span="8">
                                <el-form-item label="enkeltrom" style="text-align: center;">
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

                                            <el-button type="default">
                                                <!-- [+] legg til barneseng -->
                                                +barneseng
                                            </el-button>
                                        </div>
                                        <div class="text item">
                                            <el-row>
                                                <el-col :span="12">
                                                    <el-form-item label="navn">
                                                        <el-input></el-input>
                                                    </el-form-item>
                                                </el-col>

                                                <el-col :span="12">
                                                    <el-form-item label="fødselsdato">
                                                        <el-input></el-input>
                                                    </el-form-item>
                                                </el-col>
                                            </el-row>
                                        </div>
                                    </el-card>
                                </div>
                            </el-col>

                            <el-col :span="8" style="text-align: center;">
                                <el-form-item label="dobbeltrom">
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
                            </el-col>

                            <el-col :span="8" style="text-align: center;">
                                <el-form-item label="twintrom">
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
                            </el-col>
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
                        </el-row>
                    </section>

                    <section class="step activities">
                        <div v-show="form.activities.length">
                            <h3>Alternative Aktiviteter</h3>
                        </div>

                        <div v-for="(activity, index) in form.activities">
                            <div>
                                <h4>
                                    {{ activity.title }}
                                </h4>
                            </div>
                            
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
                                    <div @click="increment('adults', 'decrease', index)">minus</div>
                                    <input v-model.number="activity.amountAdults" type="text">
                                    <div @click="increment('adults', 'increase', index)">pluss</div>
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
                                    <div @click="increment('children', 'decrease', index)">minus</div>
                                    <input v-model.number="activity.amountChildren" type="text">
                                    <div @click="increment('children', 'increase', index)">pluss</div>
                                </el-col>
                            </el-row>
                        </div>
                    </section>

                </el-form>
            </div>

            <div slot="footer">
                <div style="display: flex; align-items: center;">
                    <h3 style="margin-right: 15px;">{{ totalPrice }},-</h3>

                    <el-button type="success" :disabled="form.name == ''">
                        Send
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
             * Computed property for the total price for the trip.
             */
            totalPrice() {
                return this.roomsPrice + this.activitiesPrice
            },
            
            /**
             * Computed property for the total price of all rooms.
             */
            roomsPrice() {
                return (this.prices.single * this.form.amountSingle) +
                       (this.prices.double * this.form.amountDouble) +
                       (this.prices.twin * this.form.amountTwin)
            },

            /**
             * Computed property for the total price of all selected activties.
             */
            activitiesPrice() {
                if (!this.form.activities) {
                    return 0
                }

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
                if (action == 'decrease' && parseInt(this.form.activities[index].amountChildren) <= 0) {
                    
                } else {
                    if (age == 'children') {
                        action == 'increase' ? 
                            parseInt(this.form.activities[index].amountChildren++) : parseInt(this.form.activities[index].amountChildren--);
                    }
                }
                
                if (action == 'decrease' && parseInt(this.form.activities[index].amountAdults) <= 0) {
                    
                } else {
                    if (age == 'adults') {
                        action == 'increase' ? 
                            parseInt(this.form.activities[index].amountAdults++) : parseInt(this.form.activities[index].amountAdults--);
                    }
                }
            }
        },

        mounted() {
            this.prices.single = trip.prices.single
            this.prices.double = trip.prices.double
            this.prices.twin = trip.prices.twin

            this.form.activities = trip.activities

            /* set initial prices now that activites has been loaded from the server */
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
</style>