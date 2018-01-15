<template>
    <div>
        <modal :show="showModal" @close="showModal = false" :title="'Påmelding ' + title">

            <div style="padding: 40px 10px; border-bottom: 1px solid #ddd;">
                <el-steps :active="activeStep" align-center> <!-- finish-status="success" direction="vertical" --> 
                    <el-step title="Hotellrom"></el-step>
                    <el-step title="Bestiller"></el-step> <!-- description="Kontakt informasjon om bestiller" -->
                    <el-step title="Valgfrie Aktiviteter"></el-step>
                    <el-step title="Annet"></el-step>
                </el-steps>
            </div>

            <div style="padding: 40px;">
                <el-form label-position="top" :model="form" @submit.native.prevent>
                    <section v-if="activeStep == 0" class="step rooms">
                        <el-row>
                            <el-col :span="8">
                                <h2 class="text-align-center">Enkeltrom</h2>

                                <h5 class="body-text">{{ prices.single }},- per person</h5>

                                <el-form-item class="text-align-center">
                                    <div class="flex-center">
                                        <el-input-number
                                            v-model="form.amountSingle"
                                            @change="onRoomChange('single')"
                                            :min="0"
                                            :max="10"
                                        ></el-input-number>
                                    </div>
                                </el-form-item>
                            </el-col>

                            <el-col :span="8">
                                <h2 class="text-align-center">Dobbeltrom</h2>

                                <h5 class="body-text">{{ prices.double }},- per person</h5>

                                <el-form-item class="text-align-center">
                                    <div class="flex-center">
                                        <el-input-number
                                            v-model="form.amountDouble"
                                            @change="onRoomChange('double')"
                                            :min="0"
                                            :max="10"
                                        ></el-input-number>
                                    </div>
                                </el-form-item>
                            </el-col>

                            <el-col :span="8">
                                <h2 class="text-align-center">Twinrom</h2>

                                <h5 class="body-text">{{ prices.twin }},- per person</h5>

                                <el-form-item class="text-align-center">
                                    <div class="flex-center">
                                        <el-input-number
                                            v-model="form.amountTwin"
                                            @change="onRoomChange('twin')"
                                            :min="0"
                                            :max="10"
                                        ></el-input-number>
                                    </div>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row class="room__cards">
                            <el-col v-for="(room, index) in form.rooms.single" :key="index" :span="12">
                                
                                <el-card class="box-card">
                                    <div slot="header" style="display: flex; align-items: center; padding: 0; margin: 0;">
                                        <div style="flex: 1; font-weight: 800;">
                                            <h2 style="margin: 6px 0; font-size: 1.3em;" v-text="'Enkeltrom ' + (index + 1)"></h2>
                                        </div>

                                        <el-form-item label="barneseng" style="width: 70px; margin: 0;">
                                            <el-select :value="0" v-model="room.numChildBeds" @change="" placeholder="legg til barneseng">
                                                <el-option :key="0" :value="0" :label="0"></el-option>
                                                <el-option :key="1" :value="1" :label="1"></el-option>
                                                <el-option :key="2" :value="2" :label="2"></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>

                                    <div class="text item" v-for="person in room.people">
                                        <el-form-item label="Navn">
                                            <el-input v-model="person.name"></el-input>
                                        </el-form-item>

                                        <el-form-item label="Fødselsdato">
                                            <el-input v-model="person.dob"></el-input>
                                        </el-form-item>
                                    </div>
                                </el-card>
                            </el-col>

                            <el-col v-for="(room, index) in form.rooms.double" :key="index" :span="12">
                                <el-card class="box-card">
                                    <div slot="header" style="display: flex; align-items: center;">
                                        <div style="flex: 1;">
                                            <!-- <strong v-text="'Dobbeltrom ' + (index + 1)"></strong> -->
                                            <h2 style="margin: 6px 0; font-size: 1.3em;" v-text="'Dobbeltrom ' + (index + 1)"></h2>
                                        </div>

                                        <!-- <el-button type="default" @click.stop="addBed('double', index)" class="add-bed__button">
                                            +barneseng
                                        </el-button> -->
                                    </div>
                                    
                                    <div class="text item">
                                        <template v-for="(person, i) in room.people">
                                            <h3 v-text="'Person ' + (i + 1)"></h3>

                                            <el-form-item label="Navn">
                                                <el-input v-model="person.name"></el-input>
                                            </el-form-item>

                                            <el-form-item label="Fødselsdato">
                                                <el-input v-model="person.dob" placeholder="dd.mm.yyyy"></el-input>
                                            </el-form-item>

                                            <div v-if="i % 2 === 0" class="separator__line"></div>
                                        </template>
                                    </div>
                                </el-card>
                            </el-col>

                            <el-col v-for="(room, index) in form.rooms.twin" :key="index" :span="12">
                                <el-card class="box-card">
                                    <div slot="header" style="display: flex; align-items: center;">
                                        <div style="flex: 1; font-weight: 800;">
                                            <h2 style="margin: 6px 0; font-size: 1.3em;" v-text="'Twinrom ' + (index + 1)"></h2>
                                        </div>

                                        <!-- <el-button type="default" @click.stop="" class="add-bed__button">
                                            [+] legg til barneseng
                                        </el-button> -->
                                    </div>
                                    
                                    <div class="text item">
                                        <template v-for="(person, i) in room.people">
                                            <h3 v-text="'Person ' + (i + 1)"></h3>

                                            <el-form-item label="Navn">
                                                <el-input v-model="person.name"></el-input>
                                            </el-form-item>

                                            <el-form-item label="Fødselsdato">
                                                <el-input v-model="person.dob" placeholder="dd.mm.yyyy"></el-input>
                                            </el-form-item>

                                            <div v-if="i % 2 === 0" class="separator__line"></div>
                                        </template>
                                    </div>
                                </el-card>
                            </el-col>
                        </el-row>
                    </section>

                    <section v-if="activeStep == 1" class="step orderer">
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

                    <section v-if="activeStep == 2" class="step activities">
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

                    <section v-if="activeStep == 3" class="step other">
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

                        <el-row type="flex" class="row-bg" justify="center" style="margin-top: 70px;">
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

                    <!-- <section v-if="activeStep == 4" class="step">
                        Oppsumering
                    </section> -->

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
                        <el-button v-if="activeStep > 0" type="default" icon="el-icon-arrow-left" @click="prevStep">
                            Tilbake <!-- el-icon-back -->
                        </el-button>

                        <el-button v-if="activeStep < 3" type="primary" @click="nextStep">
                            Neste <i class="el-icon-arrow-right el-icon-right" style="margin-left: 4px;"></i>
                        </el-button>

                        <el-button v-if="activeStep == 3" type="success" :disabled="form.travelConditions == false" @click="onSubmit()">
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
                activeStep: 0,

                title: trip.title,
                
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
             * Total price for the whole trip.
             */
            totalPrice() {
                return this.roomsPrice + this.activitiesPrice
            },

            amountSingleV() {
                return this.form.amountSingle
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
            nextStep() {
                if (this.activeStep < 4) {
                    if (this.activeStep++ > 3) {
                        // this.activeStep = 0
                    }
                }

                console.log(this.activeStep)
            },

            prevStep() {
                if (this.activeStep > 0) {
                    if (this.activeStep-- < 3) {
                        // this.activeStep = 3
                    }
                }
                console.log(this.activeStep)
            },

            onRoomChange(roomType) {
                let capitalizedRoomType = (roomType.charAt(0).toUpperCase() + roomType.slice(1))
                let prev = this.form['amount' + capitalizedRoomType] // e.g. amountDouble
             
                this.$nextTick(function () {
                    //get the difference between the current number of rooms and the newly selected amount
                    let amountAdded = (this.form['amount' + capitalizedRoomType] - prev)

                    //if the number is positive rooms have been added
                    if (amountAdded > 0) {
                        this.addRoom(amountAdded, roomType)
                    }

                    //if the number is negative rooms have beeen removed
                    if (amountAdded < 0) {
                        this.removeRoom(amountAdded, roomType)
                    }
                })
            },

            addRoom(amountAdded, roomType) {
                let numPeople = (roomType == 'single') ? 1 : 2
                
                let people = Array(numPeople).fill({ name: '', dob: '' })

                for (let i = 1; i <= amountAdded; i++) {
                    this.form.rooms[roomType].push(
                        { people, numChildBeds: 0 }
                    )
                }
            },

            removeRoom(amountAdded, roomType) {
                for (let i = 0; i < Math.abs(amountAdded); i++) {
                    this.form.rooms[roomType].splice(-1, 1)
                }
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

            onChildBedChange(roomType, index) {
                switch(roomType) {
                    case 'single':
                        // this.form.rooms.single[index].extraChildBeds = amount
                        // this.form.rooms.single.push(
                        //     {num: this.form.amountSingle + index, name: '', dob: ''}
                        // )
                        // console.log(value)
                    break;
                    case 'double':

                    break;
                    case 'twin':

                    break;
                }
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
    .room__cards .el-col:nth-child(odd) {
        padding-right: 10px;
    }
    .el-col {
        padding-bottom: 10px;
    }
    .box-card {
        /*box-shadow: 0;
        margin-bottom: 10px;*/
    }
    .separator__line {
        border-top: 1px solid #ddd;
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