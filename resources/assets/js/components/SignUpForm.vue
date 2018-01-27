<template>
    <div class="sign-up__form">
        <modal :show="showModal" @close="showModal = false" :title="'Påmelding ' + title">

            <!-- padding: 40px 0 40px 0; -->
            <div style=" box-shadow: 0px 6px 43px -20px rgba(156,154,156,1);">
                <div style="display: flex; align-items: center;">
                    <!-- description="Kontakt informasjon om bestiller" -->
                    <!-- finish-status="success" direction="vertical" -->
                    <el-steps :active="activeStep" align-center finish-status="wait" style="flex: 1;">
                        <el-step class="step__btn" @click.native="activeStep = 0" title="Hotellrom" style="border-left: 0;"></el-step>
                        <el-step class="step__btn" @click.native="activeStep = 1" title="Bestiller"></el-step>
                        <el-step class="step__btn" @click.native="activeStep = 2" title="Valgfrie Aktiviteter"></el-step>
                        <el-step class="step__btn" @click.native="activeStep = 3" title="Annet"></el-step>
                    </el-steps>
                </div>
            </div>

            <div style="padding: 40px;">
                <el-form label-position="top" :model="form" @submit.native.prevent>
                    <transition
                        name="custom-classes-transition"
                        enter-active-class="animated slideInRight"
                        @before-enter="beforeEnter"
                        @after-enter="afterEnter"
                    >
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

                            <!-- <el-row class="room__cards"> -->
                            <transition-group name="fade" tag="div" class="room__cards">
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
                                    <!-- <room-card :data="room"></room-card> -->
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
                            </transition-group>

                            <!-- </el-row> -->
                        </section>
                    </transition>

                    <transition 
                        name="custom-classes-transition"
                        enter-active-class="animated slideInRight"
                        @before-enter="beforeEnter"
                        @after-enter="afterEnter"
                    >
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
                    </transition>

                    <transition
                        name="custom-classes-transition"
                        enter-active-class="animated slideInRight"
                        @before-enter="beforeEnter"
                        @after-enter="afterEnter"
                    >
                        <section v-if="activeStep == 2 && form.activities.length != 0" class="step activities">
                            <el-col v-for="(activity, index) in form.activities" :key="index" :span="24">

                                <h2 class="text-align-center" style="margin-bottom: 30px;">{{ activity.title }}</h2>

                                <el-col :span="12" style="display: flex; justify-content: flex-end; padding-right: 15px;">
                                    <el-form-item label="Antall Barn (4-12 år)" class="text-align-center">
                                        <div class="flex-center">
                                            <el-select v-model.number="activity.amountAdults" placeholder="" style="width: 80px; padding-top: 10px;">
                                                <el-option key="0" value="0" label="0">
                                                    <span class="select-value-label">0</span>
                                                    <span class="select-hint-label"></span>
                                                </el-option>
                                                <el-option v-for="indx in numPeople" :key="indx" :value="indx" :label="indx">
                                                    <span class="select-value-label">{{ indx }}</span>
                                                    <span class="select-hint-label">{{ activity.price * indx }} kr</span>
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </el-form-item>
                                </el-col>

                                <el-col :span="12" style="display: flex; justify-content: flex-start; padding-left: 15px;">
                                    <el-form-item label="Antall Voksne" class="text-align-center">
                                        <div class="flex-center">
                                            <el-select v-model.number="activity.amountChildren" placeholder="" style="width: 80px; padding-top: 10px;">
                                                <el-option key="0" value="0" label="0">
                                                    <span class="select-value-label">0</span>
                                                    <span class="select-hint-label"></span>
                                                </el-option>
                                                <el-option v-for="indx in numPeople" :key="indx" :value="indx" :label="indx">
                                                    <span class="select-value-label">{{ indx }}</span>
                                                    <span class="select-hint-label">{{ activity.priceAfterDiscount * indx }} kr</span>
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </el-form-item>

                                    <!-- <h5 class="body-text">,- per person</h5> -->
                                </el-col>

                            </el-col>
                        </section>
                    </transition>

                    <transition
                        name="custom-classes-transition"
                        enter-active-class="animated slideInRight"
                        @before-enter="beforeEnter"
                        @after-enter="afterEnter"
                    >
                        <section v-if="activeStep == 3" class="step other">
                            <el-form-item label="Noe du ønsker å tilføye? (helse/allergier, bonuskort, m.m.) - valgfritt felt">
                                <el-input v-model="form.extra" type="textarea" :autosize="{minRows: 3}"></el-input>
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
                    </transition>

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
                        <el-button @click="prevStep" v-if="activeStep > 0" :disabled="activeStep < 1" icon="el-icon-arrow-left" style="border-radius: 0;">
                            Tilbake <!-- el-icon-back -->
                        </el-button>

                        <el-button @click="nextStep" v-if="activeStep < 3" :disabled="activeStep > 2" type="primary" style="border-radius: 0;">
                            Neste <i class="el-icon-arrow-right el-icon-right" style="margin-left: 4px;"></i>
                        </el-button>

                        <el-button v-if="activeStep == 3" type="success" :disabled="form.travelConditions == false" @click="onSubmit">
                            Send Påmelding <i class="fa fa-paper-plane" aria-hidden="true" style="margin-left: 5px;"></i>
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
    import form from '../core/Form'
    import trip from '../data'
    import modal from './utils/Modal'

    export default {
        data() {
            return {
                showModal: false,

                activeStep: 0, //current step in the form

                title: trip.title,

                // form: new Form({
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
            },

            /**
             * Amount of people signed up.
             */
            numPeople() {
                // return 0 while no hotel rooms are selected */
                if (!this.form.amountSingle || !this.form.amountDouble || !this.form.amountTwin) {
                    return 0
                }
                // todo: +children
                return this.form.amountSingle + (this.form.amountDouble * 2) + (this.form.amountTwin * 2)
            },
        },

        methods: {
            beforeEnter(el) {
                // console.log(el.parentNode.parentNode.parentNode.parentNode)
                document.querySelector('.b-modal-card-body').style.overflow = 'hidden'
                // this.$children[0].$refs.modalCardBody.style.overflow = 'hidden'
                // this.$el.querySelector(...)
            },

            afterEnter(el) {
                // console.log(el)
                // el.style.overflowX = 'auto'
                document.querySelector('.b-modal-card-body').style.overflow = 'auto'
                // console.log(this.$children.$children)
                // this.$children[0].$refs.modalCardBody.style.overflow = 'auto'
            },

            nextStep() {
                if (this.activeStep <= 3 && this.activeStep >= 0) {
                    this.activeStep++
                }
            },

            prevStep() {
                if (this.activeStep >= 0 && this.activeStep <= 3) {
                    this.activeStep--
                }
            },

            onRoomChange(roomType) {
                let capitalizedRoomType = (roomType.charAt(0).toUpperCase() + roomType.slice(1))
                let prev = this.form['amount' + capitalizedRoomType] // e.g. this.form.amountDouble
             
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
            },

            /**
             * 
             */
            onSubmit() {
                axios.post('enrollment/store', this.form).then(function(response) {
                    console.log(response.data)

                    if (response.data[0] == true) {
                        console.log(response.data[1])
                    }
                })
                .catch(function(error) {
                    console.log(error)
                })
            },
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
    .enrolment__button {
        padding: 10px 15px;
        border: 0;
        background: #FFCA2D;
        border-radius: 2px;
        cursor: pointer;
        font-weight: 800;
        font-size: 1em;
    }
    .step {
        margin-bottom: 60px;
        margin-top: 40px;
    }
    .activities, .other {
        padding-bottom: 22px;
    }
    .activities > div:not(:first-child) { /* every element except the first */
        margin-top: 40px;
    }
    .section__title {
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }
    .section__title h3 {
        padding: 0;
        margin: 0;
    }
    .room__cards {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .room__cards .el-col:nth-child(odd) {
        padding-right: 10px;
    }
    .el-col {
        padding-bottom: 10px;
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
    .total__price {
        font-size: 1.4em;
    }
    .step__btn {
        cursor: pointer;
        z-index: 10;
        border: 1px solid #ddd;
        border-right: 0;
        padding-top: 8px;
        padding-bottom: 2px;
    }
    .select-value-label {
        float: left;
    }
    .select-hint-label {
        float: right;
        color: #8492a6;
        font-size: 14px;
        padding-left: 30px;
    }
</style>