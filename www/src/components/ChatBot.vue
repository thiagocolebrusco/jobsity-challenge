<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2" xs="12">
                <ul class="messages">
                    <li :class="{'user': message.is_from_user, 'bot': !message.is_from_user}" v-for="(message, index) in messages" :key="index">
                        <span v-if="message.key">{{message.key}}</span>
                        <p class="title">{{message.is_from_user ? user.name : "Jobsity Bot"}}</p>
                        <p class="message" v-html="message.text"></p>
                        <ul v-if="message.options" class="options">
                             <li v-for="(option, o_index) in message.options" :key="o_index">{{option}}</li>
                        </ul>
                    </li>
                </ul>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="8" offset-md="2" xs="12">
                <b-input-group>
                    <b-form-input :type="input_type" @keyup.enter="Send" v-model="text" />
                    <b-input-group-append>
                        <b-button @click="Send">
                            <b-icon-caret-right-fill />
                        </b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import service from "@/services/ChatService"

export default {
    data() {
        return {
            messages: [],
            user: {
                name: "User",
                email: "",
                password: ""
            },
            text: "",
            current_action: ''
        }
    },
    computed: {
        input_type() {
            return this.current_action.key != "register_step_3" ? "text" : "password";
        }
    },
    created() {
        setTimeout(() => {
            this.messages.push({
                text: "Hello mate! How can I help you?",
                options: [
                    "Log in",
                    "Sign up"
                ],
                is_from_user: false
            })
        }, 1000)
    },
    methods: {
        Send() {
            this.messages.push({
                text: this.text,
                is_from_user: true
            })
            this.CheckIfResponseMeansActionOnClient();
            let message = {
                text: this.text,
                next_step: this.current_action.next_step,
                additional_data: this.additional_data
            }
            this.text = ''
            service.Send(message).then((response) => {
                this.additional_data = null;
                if(response.data){
                    let bot_response = {
                        key: response.data.key,
                        text: this.ReplaceWithUserData(response.data.message),
                        is_from_user: false
                    }
                    this.current_action = response.data
                    this.messages.push(bot_response)
                }
            })
        },
        CheckIfResponseMeansActionOnClient() {
            if(this.current_action.client_action){
                this[this.current_action.client_action]();
            }
            // switch(this.current_action){
            //     case 'start_register':
            //         this.user.name = this.text
            //         return {
            //             next_step: 'register_step_2',
            //             additional_data: null
            //         };
            //     case 'register_step_2':
            //         this.user.email = this.text
            //         return {
            //             next_step: 'register_step_3',
            //             additional_data: null
            //         };
            //     case 'register_step_3':
            //         this.user.password = this.text
            //         return {
            //             next_step: 'register_step_4',
            //             additional_data: null
            //         };
            //     case 'register_step_4':
            //         this.user.currency = this.text
            //         return {
            //             next_step: 'register_complete',
            //             additional_data: JSON.stringify(this.user)
            //         };
            //     default:
                    // return {
                    //     next_step: null,
                    //     additional_data: null
                    // };
            // }
        },
        ReplaceWithUserData(message) {
            let n = message.match(/{{(.*)}}/)
            if(n) {
                console.log(n)
                message = message.replace(n[0], this.user[n[1]])
            }
            return message
        },
        SetUserName() {
            this.user.name = this.text
        },
        SetUserEmail() {
            this.user.email = this.text
        },
        SetUserPassword() {
            this.user.password = this.text
        },
        SetUserCurrency() {
            this.user.currency = this.text
            this.additional_data = JSON.stringify(this.user)
        }
    }
}
</script>

<style>
    .messages {
        margin: 0;
        padding: 0;
    }

    .messages > li {
        list-style: none;
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        color: white;
    }

    .messages > li > .title {
        font-weight: bold;
        margin: 0;
    }

    .messages > li > .message {
        margin: 10px;
    }

    .messages > .bot {
        text-align: left;
        background-color: lightgreen;
    }

    .messages > .user {
        text-align: right;
        background-color: blueviolet;
    }

    .messages > li > .options {
        padding: 0;
    }

    .messages > li > .options > li {
        list-style: none;
        background-color: white;
        color: blue;
        display: inline-block;
        padding: 5px 15px;
        margin: 0 10px;
        border-radius: 10px;
    }
</style>