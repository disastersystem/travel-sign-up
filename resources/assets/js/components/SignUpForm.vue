<template>
    <div>  
        <modal :show="showModal" @close="showModal = false" title="Påmelding">
            <section style="padding: 40px;">
                <el-form label-position="top" label-width="100px" :model="form">

                    <el-row>
                        <el-col :span="8" class="text-center">
                            <el-form-item label="enkeltrom">
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
                                <el-form-item :label="'rom ' + room.num">
                                    <el-input></el-input>
                                </el-form-item>
                            </div>
                        </el-col>

                        <el-col :span="8" class="text-center">
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

                        <el-col :span="8" class="text-center">
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
                        </el-col>

                        <div v-for="(room, index) in form.rooms.twin">
                            <el-form-item :label="index % 2 === 0 ? 'rom ' + room.num : ''">
                                <el-input></el-input>
                            </el-form-item>
                        </div>
                    </el-row>

                </el-form>
            </section>

            <p slot="footer">
                <el-button type="success" :disabled="form.name == ''">
                    Send
                </el-button>
            </p>
        </modal>

        <button class="enrolment__button" @click="showModal = true">
            Påmelding
        </button>
    </div>
</template>

<script>
    import data from '../data'
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
                    city: ''
                }
            }
        },

        components: {
            modal
        },

        methods: {
            onSingleChange(numRooms) {
                let amountAdded = (numRooms - this.form.rooms.single.length)

                /* if the number is positive: rooms added */
                if (amountAdded > 0) {
                    for (let i = 0; i < amountAdded; i++) {
                        this.form.rooms.single.push({num: this.form.rooms.single.length + 1, name: '', dob: ''})
                    }
                }

                /* if the number is negative: rooms removed */
                if (amountAdded < 0) {
                    for (let i = 0; i < Math.abs(amountAdded); i++) {
                        this.form.rooms.single.splice(-1, 1)
                    }
                }
            },

            onDoubleChange(value) {
                let amountAdded = (value - this.form.rooms.double.length)

                /* if the number is positive */
                if (amountAdded > 0) {
                    for (let i = 0; i < amountAdded; i++) {
                        this.form.rooms.double.push(
                            {num: this.form.rooms.double.length + 1, name: '', dob: ''},
                            {num: this.form.rooms.double.length + 1, name: '', dob: ''}
                        )
                    }
                }

                /* if the number is negative */
                if (amountAdded < 0) {
                    for (let i = 0; i < Math.abs(amountAdded); i++) {
                        this.form.rooms.double.splice(-2, 2)
                    }
                }
            },

            onTwinChange() {

            }
        }
    }
</script>

<style scoped>
    .text-center {
        text-align: center;
        padding: 0 10px;
    }

    .flex-center {
        display: flex;
        justify-content: center;
    }
</style>