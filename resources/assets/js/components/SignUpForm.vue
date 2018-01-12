<template>
    <div>
        <modal :show="showModal" @close="showModal = false" :title="'Påmelding ' + title">
            <div style="padding: 40px;">

            <!-- <el-steps :active="1" align-center>
                <el-step title="Hotell" description="Velg hotellrom"></el-step>
                <el-step title="Bestiller" description="Kontakt informasjon om bestiller"></el-step>
                <el-step title="Aktiviteter" description="Velg tilleggsaktiviteter"></el-step>
                <el-step title="Annet" description="Tilleggsinfomasjon"></el-step>
            </el-steps> -->

                <el-form label-position="top" :model="form" @submit.native.prevent>

                    <section class="step rooms">
                        <div class="section__title">
                            <h3>Hotellrom</h3>
                        </div>

                        <el-row>
                            <el-col :span="8">
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
                            </el-col>

                            <el-col :span="8">
                                <el-form-item label="dobbeltrom" style="text-align: center;">
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
                            </el-col>

                            <el-col :span="8">
                                <el-form-item label="twinrom" style="text-align: center;">
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
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col v-for="(room, index) in form.rooms.single" :span="12" :key="index">
                                <el-card class="box-card" style="box-shadow: 0; margin-bottom: 10px;">
                                    <div slot="header" style="display: flex; align-items: center;">
                                        <div style="flex: 1; font-weight: 800;">
                                            <strong v-text="'Enkeltrom ' + room.num"></strong>
                                        </div>

                                        <!-- <el-button type="default" @click.stop="" class="add-bed__button">
                                            legg til barneseng [+]
                                            +barneseng
                                        </el-button> -->
                                        <el-form-item label="Ekstra barneseng">
                                            <el-select :value="0" @change="" placeholder="legg til barneseng [+]">
                                                <el-option :key="0" :value="0" :label="0"></el-option>
                                                <el-option :key="1" :value="1" :label="1"></el-option>
                                                <el-option :key="2" :value="2" :label="2"></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>

                                    <div class="text item">
                                        <el-form-item label="Navn">
                                            <el-input></el-input>
                                        </el-form-item>

                                        <el-form-item label="Fødselsdato">
                                            <el-input></el-input>
                                        </el-form-item>
                                    </div>
                                </el-card>
                            </el-col>

                            <el-col v-for="(room, index) in form.rooms.double" :span="12" :key="index" v-if="index % 2 === 0">
                                <el-card class="box-card" style="box-shadow: 0; margin-bottom: 10px;">
                                    <div slot="header" style="display: flex; align-items: center;">
                                        <div style="flex: 1; font-weight: 800;">
                                            <strong v-text="'Dobbeltrom ' + room.num"></strong>
                                        </div>

                                        <el-button type="default" @click.stop="addBed('double', index)" class="add-bed__button">
                                            +barneseng
                                        </el-button>
                                    </div>
                                    
                                    <div class="text item">
                                        <p>Person 1</p>
                                        <el-form-item label="Navn">
                                            <el-input v-model="room.name"></el-input>
                                        </el-form-item>

                                        <el-form-item label="Fødselsdato">
                                            <el-input v-model="room.dob" placeholder="dd.mm.yyyy"></el-input>
                                        </el-form-item>

                                        <div style="border-top: 1px solid #ddd;"></div>
                                        <p>Person 2</p>
                                        <el-form-item label="Navn">
                                            <el-input v-model="form.rooms.double[index + 1].name"></el-input>
                                        </el-form-item>

                                        <el-form-item label="Fødselsdato">
                                            <el-input v-model="form.rooms.double[index + 1].dob" placeholder="dd.mm.yyyy"></el-input>
                                        </el-form-item>
                                    </div>
                                </el-card>
                            </el-col>

                            <el-col v-for="(room, index) in form.rooms.twin" :span="12" :key="index" v-if="index % 2 === 0">
                                <el-card class="box-card" style="box-shadow: 0; margin-bottom: 10px;">
                                    <div slot="header" style="display: flex; align-items: center;">
                                        <div style="flex: 1; font-weight: 800;">
                                            <strong v-text="'Twinrom ' + room.num"></strong>
                                        </div>

                                        <el-button type="default" @click.stop="" class="add-bed__button">
                                            [+] legg til barneseng <!-- +barneseng -->
                                        </el-button>
                                    </div>
                                    
                                    <div class="text item">
                                        <!-- <el-col :span="12"> -->
                                            <p>Person 1</p>
                                            <el-form-item label="Navn">
                                                <el-input v-model="room.name"></el-input>
                                            </el-form-item>

                                            <el-form-item label="Fødselsdato">
                                                <el-input v-model="room.dob" placeholder="dd.mm.yyyy"></el-input>
                                            </el-form-item>
                                        <!-- </el-col> -->

                                        <!-- <el-col :span="12"> -->
                                            <div style="border-top: 1px solid #ddd;"></div>
                                            <p>Person 2</p>
                                            <el-form-item label="Navn">
                                                <el-input v-model="form.rooms.twin[index + 1].name"></el-input>
                                            </el-form-item>

                                            <el-form-item label="Fødselsdato">
                                                <el-input v-model="form.rooms.twin[index + 1].dob" placeholder="dd.mm.yyyy"></el-input>
                                            </el-form-item>
                                        <!-- </el-col> -->
                                    </div>
                                </el-card>
                            </el-col>
                        </el-row>
                    </section>

                    <section class="step orderer">
                        <div class="section__title">
                            <h3>Bestiller</h3>
                        </div>

                        <el-row>
                            <el-form-item label="Navn (som i pass)">
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

                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="Postnr">
                                        <el-input v-model="form.postalcode" style="width: 140px;"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="12">
                                    <el-form-item label="Poststed">
                                        <el-input v-model="form.city"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-row>
                    </section>

                    <section class="step activities">
                        <div v-show="form.activities.length" class="section__title">
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

                    <section class="step other">
                        <div class="section__title">
                            <h3>Annet</h3>
                        </div>

                        <el-form-item label="Noe du ønsker å tilføye? (helse/allergier, bonuskort, m.m.) - valgfritt felt">
                            <el-input v-model="form.extra" type="textarea" :autosize="{minRows: 2}"></el-input>
                        </el-form-item>

                        <el-form-item label="Ønsket avreisested">
                            <el-select v-model="form.departure" placeholder="Avreisested">
                                <el-option key="Gjøvik" value="Gjøvik" label="Gjøvik"></el-option>
                                <el-option key="Hunndalen" value="Hunndalen" label="Hunndalen"></el-option>
                                <el-option key="Raufoss" value="Raufoss" label="Raufoss"></el-option>
                                <el-option key="Reinsvoll" value="Reinsvoll" label="Reinsvoll"></el-option>
                                <el-option key="Eina" value="Eina" label="Eina"></el-option>
                                <el-option key="Gran" value="Gran" label="Gran"></el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Flybilletter">
                            <el-checkbox style="background: #fff;"
                                v-model="form.planeTickets"
                                label="Ønsker å bestille reisen med flybilletter"
                                border
                            ></el-checkbox>
                        </el-form-item>
                    </section>

                    <section class="step">
                        <el-row type="flex" class="row-bg" justify="center">
                            <el-checkbox
                                class="conditions__checkbox"
                                v-model="form.travelConditions"
                                label="Jeg har lest og godtar"
                                border
                            ></el-checkbox>

                            <div class="conditions__link">
                                <a target="_blank" href="reisebetingelser.html">
                                    reisebetingelsene 
                                </a>
                                
                                <i class="material-icons" style="color: #ccc; font-size: 18px; margin-left: 5px;">
                                    open_in_new
                                </i>
                            </div>
                        </el-row>
                    </section>

                </el-form>
            </div>

            <div slot="footer">
                <div class="space-between">
                    <div>
                        <span class="total__price">
                            Totalt {{ totalPrice }} kr
                        </span>
                    </div>
                    
                    <div>
                        <el-button type="success" :disabled="form.travelConditions == false" @click="onSubmit()">
                            Send påmelding <i class="fa fa-paper-plane" aria-hidden="true" style="margin-left: 5px;"></i>
                        </el-button>
                    </div>
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
                child: 0, // this need to be linked with the room itself

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

                    activities: [],

                    planeTickets: false,
                    travelConditions: false
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
            },

            addBed(roomType, index) {
                // switch(roomType) {
                //     case 'single':
                //         this.form.rooms.double[index].push()
                //         break;
                //     case 'double':

                //         break;
                //     case 'twin':

                //         break;
                // }
            }
        },

        onSubmit() {
            console.log('Attempt submit')
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
        margin-bottom: 60px;
        margin-top: 40px;
    }
    .activities, .other {
        padding-bottom: 22px;
    }
    .section__title {
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }
    .section__title h3 {
        padding: 0;
        margin: 0;
    }
    .el-card:nth-child(odd) {
        margin-right: 40px;
    }
    .conditions__checkbox {
        background: #fff;
        border-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .conditions__link {
        display: flex;
        text-align: center;
        align-items: center;
        padding-right: 8px;
        border: 1px solid #c1c1c1; 
        border-radius: 4px;
        border-left: 1px dashed #c1c1c1;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding-left: 10px;
        line-height: 19px;
        font-size: 14px;
    }
    .space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total__price {
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