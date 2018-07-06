<template>
    <div class="sign-up__form">
        <!-- modal -->
        <modal
            @close="showModal = false"
            :title="'Påmelding ' + shared.tripData.title" :subtitle="'- ' + shared.tripData.date"
            :show="showModal"
            :loading="submitted"
            ref="modal"
        >
            <!-- The form view, which is separated into sections: hotel rooms, orderer, activtities, other/misc. 
            This view is visible until the form has been submitted. -->
            <div class="form__view" slot="content" v-if="completed == false">
                <div class="top__menu">
                    <div class="flex-horizontal-center">
                        <el-steps :active="activeStep" align-center finish-status="wait" class="flex-1">
                            <el-step class="step__btn border-left-none" @click.native="activeStep = 0" title="Hotellrom"></el-step>
                            <el-step class="step__btn" @click.native="activeStep = 1" title="Bestiller"></el-step>
                            <!-- v-if="form.activities.length != 0" TO MAKE THIS WORK: we need to not hardcode the steps -->
                            <el-step class="step__btn" @click.native="activeStep = 2" title="Valgfrie Aktiviteter"></el-step>
                            <el-step class="step__btn" @click.native="activeStep = 3" title="Annet"></el-step>
                        </el-steps>
                    </div>
                </div>

                <div class="form__wrapper">
                    <el-form label-position="top" :model="form" @submit.native.prevent>
                        <!-- hotel rooms -->
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

                                        <h5 class="body-text">
                                            {{ shared.tripData.prices.single }},- per person
                                        </h5>

                                        <el-form-item class="text-align-center">
                                            <div class="flex-vertical-center">
                                                <el-input-number
                                                    v-model="form.amountSingle"
                                                    @change="onRoomChange('single')"
                                                    :min="0"
                                                    :max="10"
                                                    class="number__input"
                                                ></el-input-number>
                                            </div>
                                        </el-form-item>
                                    </el-col>

                                    <el-col :span="8">
                                        <h2 class="text-align-center">Dobbeltrom</h2>

                                        <h5 class="body-text">
                                            {{ shared.tripData.prices.double }},- per person
                                        </h5>

                                        <el-form-item class="text-align-center">
                                            <div class="flex-vertical-center">
                                                <el-input-number
                                                    v-model="form.amountDouble"
                                                    @change="onRoomChange('double')"
                                                    :min="0"
                                                    :max="10"
                                                    class="number__input"
                                                ></el-input-number>
                                            </div>
                                        </el-form-item>
                                    </el-col>

                                    <el-col :span="8">
                                        <h2 class="text-align-center">Twinrom</h2>

                                        <h5 class="body-text">
                                            {{ shared.tripData.prices.twin }},- per person
                                        </h5>

                                        <el-form-item class="text-align-center">
                                            <div class="flex-vertical-center">
                                                <el-input-number
                                                    v-model="form.amountTwin"
                                                    @change="onRoomChange('twin')"
                                                    :min="0"
                                                    :max="10"
                                                    class="number__input"
                                                ></el-input-number>
                                            </div>
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <transition-group name="fade" tag="div" class="room__cards">

                                    <!-- SINGLE room -->
                                    <el-col v-for="(room, index) in form.rooms.single" :key="index" :span="12">
                                        <el-card class="box-card">
                                            <div slot="header" class="box-card-header">
                                                <div class="box-card-title-container">
                                                    <h2 class="box-card-title" v-text="'Enkeltrom ' + (index + 1)"></h2>
                                                </div>

                                                <el-form-item label="barneseng" class="margin-none">
                                                    <el-select class="add-bed__button" :value="0" v-model="room.numChildBeds" @change="onExtraBedChange(room)">
                                                        <el-option :key="0" :value="0" :label="0"></el-option>
                                                        <el-option :key="1" :value="1" :label="1"></el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>

                                            <div class="text item" v-for="(person, p) in room.people" :key="p">
                                                <el-row class="margin-b-20">
                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="person.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="person.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>

                                            <div class="text item" v-for="(child, i) in room.extraBeds">
                                                <div v-if="i % 2 === 0" class="separator__line"></div>
                                                
                                                <h3>Ekstra barneseng</h3>

                                                <el-row class="margin-b-20">
                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="child.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="child.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>
                                        </el-card>
                                    </el-col>

                                    <!-- DOUBLE room -->
                                    <el-col v-for="(room, index) in form.rooms.double" :key="index" :span="12">
                                        <el-card class="box-card">
                                            <div slot="header" class="flex-horizontal-center">
                                                <div class="flex-1">
                                                    <h2 class="box-card-title" v-text="'Dobbeltrom ' + (index + 1)"></h2>
                                                </div>

                                                <el-form-item label="barneseng" class="margin-none">
                                                    <el-select class="add-bed__button" :value="0" v-model="room.numChildBeds" @change="onExtraBedChange(room)">
                                                        <el-option :key="0" :value="0" :label="0"></el-option>
                                                        <el-option :key="1" :value="1" :label="1"></el-option>
                                                        <el-option :key="2" :value="2" :label="2"></el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                            
                                            <div class="text item" v-for="(person, i) in room.people" :key="i">
                                                <el-row class="margin-b-20">
                                                    <h3 class="form-section-title" v-text="'Person ' + (i + 1)"></h3>
                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="person.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="person.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>

                                            <div class="text item" v-for="(child, i) in room.extraBeds">
                                                <div v-if="i % 2 === 0" class="separator__line"></div>

                                                <h3>
                                                    Extra barneseng
                                                    <span v-if="room.numChildBeds > 1">
                                                        {{ i + 1 }}
                                                    </span>
                                                </h3>

                                                <el-row class="margin-b-20">
                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="child.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="child.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>
                                        </el-card>
                                    </el-col>

                                    <!-- TWIN room -->
                                    <el-col v-for="(room, index) in form.rooms.twin" :key="index" :span="12">
                                        <el-card class="box-card">
                                            <div slot="header" class="flex-horizontal-center">
                                                <div class="flex-1">
                                                    <h2 class="box-card-title" v-text="'Twinrom ' + (index + 1)"></h2>
                                                </div>

                                                <el-form-item label="barneseng" class="margin-none">
                                                    <el-select class="add-bed__button" :value="0" v-model="room.numChildBeds" @change="onExtraBedChange(room)">
                                                        <el-option :key="0" :value="0" :label="0"></el-option>
                                                        <el-option :key="1" :value="1" :label="1"></el-option>
                                                        <el-option :key="2" :value="2" :label="2"></el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                            
                                            <div class="text item" v-for="(person, i) in room.people">
                                                <el-row class="margin-b-20">
                                                    <h3 class="form-section-title" v-text="'Person ' + (i + 1)"></h3>

                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="person.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="person.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>

                                            <div class="text item" v-for="(child, i) in room.extraBeds">
                                                <div v-if="i % 2 === 0" class="separator__line"></div>
                                                
                                                <h3>
                                                    Ekstra barneseng
                                                    <span v-if="room.numChildBeds > 1">
                                                        {{ i + 1 }}
                                                    </span>
                                                </h3>

                                                <el-row class="margin-b-20">
                                                    <el-col :span="24">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Navn</label>
                                                            <p class="helper-text">Fornavn Etternavn</p>
                                                            <el-input v-model="child.name" class="no-bottom-margin"></el-input>
                                                        </div>
                                                    </el-col>

                                                    <el-col :span="8">
                                                        <div class="margin-b-10">
                                                            <label class="input-label">Fødselsdato</label>
                                                            <p class="helper-text">dd.mm.yyyy</p>
                                                            <el-input v-model="child.dob"></el-input>
                                                        </div>
                                                    </el-col>
                                                </el-row>
                                            </div>
                                        </el-card>
                                    </el-col>
                                </transition-group>
                                
                            </section>
                        </transition>

                        <!-- orderer -->
                        <transition
                            name="custom-classes-transition"
                            enter-active-class="animated slideInRight"
                            @before-enter="beforeEnter"
                            @after-enter="afterEnter"
                        >
                            <section v-if="activeStep == 1" class="step orderer flex-vertical-center">
                                <el-col :xl="12" :lg="12" :md="12" :sm="24" :xs="24">
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

                                    <el-row>
                                        <el-col :span="8" :xs="24">
                                            <el-form-item label="Postnr" class="postal-code__input">
                                                <el-input v-model="form.postalcode"></el-input>
                                            </el-form-item>
                                        </el-col>
                                        <el-col :span="16" :xs="24">
                                            <el-form-item label="Poststed">
                                                <el-input v-model="form.city"></el-input>
                                            </el-form-item>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </section>
                        </transition>

                        <!-- activities -->
                        <transition
                            name="custom-classes-transition" 
                            enter-active-class="animated slideInRight"
                            @before-enter="beforeEnter"
                            @after-enter="afterEnter"
                        >
                            <section v-if="activeStep == 2 && shared.tripData.activities.length != 0" class="step activities">
                                <el-row v-for="(activity, index) in shared.tripData.activities" :key="index">

                                    <h2 class="activity-title text-align-center">{{ activity.title }}</h2>

                                    <el-col :span="12" class="amount-children__container">
                                        <el-form-item label="Voksne" class="text-align-center">
                                            <div class="flex-vertical-center">
                                                <el-select v-model.number="activity.amountChildren" :disabled="numPeople == 0" class="amount__select">
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
                                    </el-col>

                                    <el-col :span="12" class="amount-adults__container">
                                        <el-form-item label="Barn (4-12 år)" class="text-align-center">
                                            <div class="flex-vertical-center">
                                                <el-select v-model.number="activity.amountAdults" :disabled="numPeople == 0" class="amount__select">
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

                                </el-row>
                            </section>
                        </transition>

                        <!-- misc/other -->
                        <transition
                            name="custom-classes-transition"
                            enter-active-class="animated slideInRight"
                            @before-enter="beforeEnter"
                            @after-enter="afterEnter"
                        >
                            <section v-if="activeStep == 3" class="step other">
                                <div class="margin-b-20">
                                    <div>
                                        <label class="label-optional-field">
                                            Noe du ønsker å tilføye? (helse/allergier, bonuskort, m.m.)
                                        </label>
                                        <span class="helper-text">- valgfritt felt</span>
                                    </div>
                                    
                                    <el-input v-model="form.extra" type="textarea" :autosize="{minRows: 3}"></el-input>
                                </div>

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
                                    <el-checkbox
                                        v-model="form.planeTickets"
                                        label="Ønsker å bestille reisen med flybilletter"
                                        border
                                        class="plane-tickets__checkbox"
                                    ></el-checkbox>
                                </el-form-item>

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
                                        
                                        <i class="material-icons open-in-new">
                                            open_in_new
                                        </i>
                                    </div>
                                </el-row>
                            </section>
                        </transition>
                    </el-form>
                </div>
            </div>

            <!-- Teh view that's visible when the form has been submitted successfully. -->
            <div class="completed__view" slot="content" v-if="completed == true">
                <section class="flex-full-center" style="flex-direction: column;">
                    <div class="server-message">
                        {{ serverResponse }}
                    </div>

                    <!-- go back to the form view -->
                    <el-button v-if="completed != true" @click="completed = false" class="no-rounding">
                        Try again
                    </el-button>
                </section>
            </div>

            <div slot="footer" v-if="completed == false">
                <div class="space-between">
                    <span class="total__price">
                        {{ totalPrice }} kr
                    </span>

                    <div>
                        <el-button v-if="activeStep > 0" @click="prevStep" :disabled="activeStep < 1" icon="el-icon-arrow-left" class="no-rounding">
                            Tilbake
                        </el-button>

                        <el-button v-if="activeStep < 3" @click="nextStep" :disabled="activeStep > 2" type="primary" class="no-rounding">
                            Neste <i class="el-icon-arrow-right el-icon-right"></i>
                        </el-button>

                        <el-button v-if="activeStep == 3" @click="onSubmit" :disabled="form.travelConditions == false" type="success">
                            Send Påmelding <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </el-button>
                    </div>
                </div>
            </div>
        </modal>

        <!-- opens modal -->
        <button class="enrolment__button" @click="showModal = true">
            Påmelding
        </button>
    </div>
</template>

<script>
    import store from '../store' //shared data
    import form from '../core/Form'
    import trip from '../data'
    import modal from './utils/Modal'

    export default {
        data() {
            return {
                showModal: false,

                //the trip data from the db, shared among this component and the EnrolmentForm component
                shared: store,

                //current step in the form
                activeStep: 0,

                //has the form been submitted
                submitted: false,

                //has the form been succesfully completed
                completed: false,

                //success or failure message from the server after form submit
                serverResponse: '',
                
                //data that's bound to form elements and should be sent when the form is submitted
                form: {
                    //how many of each room type is selected
                    //TODO: look into whether we need these
                    amountSingle: 0,
                    amountDouble: 0,
                    amountTwin: 0,
                    
                    //holds data about the people in the different hotel rooms
                    rooms: {
                        single: [],
                        double: [],
                        twin: []
                    },

                    //data related to the person ordering
                    name: '',
                    mail: '',
                    phone: '',
                    address: '',
                    postalcode: '',
                    city: '',

                    //misc data
                    extra: '',
                    departure: 'Gjøvik',

                    //holds data about the trips optional activities and how many people is joining each
                    activities: [],

                    planeTickets: false,

                    //whether the travels conditions has been accepted
                    travelConditions: false
                }
            }
        },

        components: {
            modal
        },

        computed: {
            /**
             * We may or may not have any alternative activities for a trip.
             */
            totalSteps() {
                // if (this.form.activities.length == 0) {
                //     return 2
                // }
                // return 3
            },

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
                return (this.shared.tripData.prices.single * this.form.amountSingle) +
                       (this.shared.tripData.prices.double * this.form.amountDouble) +
                       (this.shared.tripData.prices.twin   * this.form.amountTwin)
            },

            /**
             * Total price of all selected activties.
             */
            activitiesPrice() {
                //return 0 if the trip does not have any extra activities
                if (!this.shared.tripData.activities) {
                    return 0
                }

                //calculate the total price
                return this.shared.tripData.activities.reduce(function(total, value) {
                    return total + Number(
                        (value.price * value.amountAdults) + (value.priceAfterDiscount * value.amountChildren)
                    )
                }, 0)
            },

            /**
             * Amount of people signed up (caculated from selected hotel rooms).
             */
            numPeople() {
                //return 0 while no hotel rooms are selected
                if (this.form.amountSingle == 0 && this.form.amountDouble == 0 && this.form.amountTwin == 0) {
                    return 0
                }
                //todo: +children
                return  this.form.amountSingle +
                        (this.form.amountDouble * 2) +
                        (this.form.amountTwin * 2)
            }
        },

        methods: {
            /**
             * Advance to the next step in the form. This is used by the "next" button.
             */
            nextStep() {
                //go forward (increment the current step) one step if we're not on the last step.
                if (this.activeStep <= 3 && this.activeStep >= 0) {
                    this.activeStep++
                }
            },

            /**
             * Go back one step in the the form. This is used by the "back" button.
             */
            prevStep() {
                //go back (decrement the current step) one step if we're not on the first step.
                if (this.activeStep >= 0 && this.activeStep <= 3) {
                    this.activeStep--
                }
            },

            /**
             * Hide the scrollbar of the modal card content before animating 
             * (before running the transition) to the next step in the form.
             */
            beforeEnter(el) {
                this.$children[0].$refs.modalCardBody.style.overflow = 'hidden'
            },

            /**
             * Show the scrollbar of the modal card content after the animation 
             * (after running the transition) to the next step in the form. 
             */
            afterEnter(el) {
                this.$children[0].$refs.modalCardBody.style.overflow = 'auto'
            },

            /**
             * The user has changed (increased or decreased by any number)
             * the amount of rooms for ANY of the room types.
             */
            onRoomChange(roomType) {
                let capitalizedRoomType = (roomType.charAt(0).toUpperCase() + roomType.slice(1))
                let prevAmount = this.form['amount' + capitalizedRoomType] //e.g. this.form.amountDouble
                
                this.$nextTick(function () {
                    //get the difference between the current number of rooms and the newly selected amount
                    let amountAdded = (this.form['amount' + capitalizedRoomType] - prevAmount)

                    //if the number is positive rooms have been added
                    if (amountAdded > 0) {
                        this.addRoom(amountAdded, roomType)
                    } else if (amountAdded < 0) { //negative number = rooms removed
                        this.removeRoom(amountAdded, roomType)
                    }
                })
            },

            /**
             * Add any number of rooms for the specified room type.
             */
            addRoom(amountAdded, roomType) {
                let numPeople = (roomType == 'single') ? 1 : 2
                
                let people = [];
                //push as many people objects as the room type dictates
                for (let i = 1; i <= numPeople; i++) {
                    people.push({ name: '', dob: '' })
                }

                let extraBeds = []
                //push as many rooms as the user added
                for (let i = 1; i <= amountAdded; i++) {
                    this.form.rooms[roomType].push(
                        { people, numChildBeds: 0, extraBeds }
                    )
                }
            },

            /**
             * Remove any amount of rooms for any room type.
             */
            removeRoom(amountAdded, roomType) {
                for (let i = 0; i < Math.abs(amountAdded); i++) {
                    this.form.rooms[roomType].splice(-1, 1)
                }
            },

            /**
             * Remove any amount of rooms for any room type.
             */
            onExtraBedChange(room) {
                this.$nextTick(function () { //todo: do we need $nextTick?
                    room.extraBeds = []

                    for (let i = 1; i <= room.numChildBeds; i++) {
                        room.extraBeds.push({ name: '', dob: '' })
                    }
                })
            },

            /**
             * Send the form data to the server.
             */
            onSubmit() {
                this.submitted = true //this starts loading indication

                axios.post('enrollment/store', [this.form, this.shared.tripData.activities]).then((response) => {
                    this.serverResponse = response.data[1]
                    this.submitted = false
                    this.completed = true //show the completed view, hide form view
                }).catch((response) => {
                    this.serverResponse = response.data[1]
                    this.submitted = false
                })
            }
        },

        mounted() {
            // var self = this
            // this.shared.tripData.activities.forEach(function(activity) {
            //     self.form.activtities.push('amountAdults', 0)
            //     self.form.activtities.push('amountChildren', 0)
            // })
        }
    }
</script>

<style scoped>
    .top__menu {
        position: absolute; 
        left: 0;
        right: 0;
        z-index: 10;
        box-shadow: 0px 6px 43px -20px rgba(156,154,156,1);
        background: rgba(255,255,255,1);
    }

    .form__wrapper {
        padding: 40px;
        padding-top: 100px;
    }

    .number__input {
        width: 150px;
        font-size: 30px;
    }

    .box-card-header {
        display: flex;
        align-items: center;
        padding: 0;
        margin: 0;
    }

    .box-card-title-container {
        flex: 1;
        font-weight: 800;
    }

    .box-card-title {
        margin: 6px 0;
        font-size: 1.3em;
    }

    .amount-children__container {
        display: flex;
        justify-content: flex-end;
        padding-right: 15px;
    }

    .amount-adults__container {
        display: flex; 
        justify-content: flex-start;
        padding-left: 15px;
    }

    .amount__select {
        width: 80px;
        padding-top: 10px;
    }

    .plane-tickets__checkbox {
        background: #fff;
    }

    .row-bg {
        margin-top: 70px;
    }

    .activity-title {
        margin-bottom: 30px;
    }

    .postal-code__input {
        padding-right: 15px;
    }

    .add-bed__button {
        border-color: #E6A23C;
        width: 70px;
    }

    .enrolment__button {
        /*width: 200px;*/
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

    .room__cards .el-col:nth-child(odd) { /* every odd element */
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

    .button-text {
        padding: 10px 0;
    }

    /* used to reset border rounding on framework elements */
    .no-rounding {
        border-radius: 0;
    }

    .flex-1 {
        flex: 1;
    }

    .border-left-none {
        border-left: 0;
    }

    .margin-none {
        margin: 0;
    }

    .el-icon-arrow-right,
    .fa-paper-plane {
        margin-left: 4px;
    }

    .open-in-new {
        color: #ccc;
        font-size: 18px;
        margin-left: 5px;
    }

    /* */
    .form-section-title {
        margin: 0;
        padding: 0;
        text-align: center;
        margin-bottom: 10px;
        color: #bbb;
    }

    .margin-b-10 {
        margin-bottom: 10px;
    }

    .margin-b-20 {
        margin-bottom: 20px;
    }

    .helper-text {
        margin: 3px 0;
        padding: 0;
        color: #bbb;
        font-style: italic;
        font-size: 13px;
    }

    .input-label {
        display: block;
        font-size: 15px;
    }

    .no-bottom-margin {
        margin: 0;
    }

    .label-optional-field {
        font-size: 14px;
        color: #606266;
        font-family: 'Raleway', 'Arial';
        font-weight: 600;
    }

    .server-message {
        padding: 30px;
        font-family: Arial;
        /*color: green;*/
        font-size: 20px;
    }
</style>