<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2" xs="12">
                <ul class="messages">
                    <li :class="{'user': message.is_from_user, 'bot': !message.is_from_user}" v-for="(message, index) in messages" :key="index">
                        <p class="title">{{message.is_from_user ? user.name : "Jobsity Bot"}}</p>
                        <p class="message" v-html="message.text"></p>
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
                id: null,
                name: "User",
                email: "",
                password: ""
            },
            transaction: {
                amount: null,
                currency: null,
            },
            text: "",
            current_action: '',
            input_type: 'text'
        }
    },
    created() {
        if(localStorage.getItem("user")){
            this.user = JSON.parse(localStorage.getItem("user"))
        }
        setTimeout(() => {
            if(! this.user.id){
                this.messages.push({
                    text: "Hello mate! How can I help you?",
                    is_from_user: false
                })
            } else {
                this.messages.push({
                    text: `Welcome back, <strong>${this.user.name}</strong>! What can I do for you?`,
                    is_from_user: false
                })
            }
        }, 1000)
    },
    methods: {
        Send() {
            this.SetInputTypeToText();
            this.CheckIfResponseMeansActionOnClient();
            this.messages.push({
                text: this.text,
                is_from_user: true
            })
            let message = {
                text: this.text,
                next_step: this.current_action.next_step,
                additional_data: this.additional_data
            }
            this.text = ''
            service.Send(message).then((response) => {
                this.additional_data = null;
                if(response.data){
                    let bot_response = response.data.bot_response;
                    let bot_message = {
                        key: bot_response.key,
                        text: this.ReplaceWithUserData(bot_response.message),
                        is_from_user: false
                    }
                    this.current_action = bot_response
                    this.messages.push(bot_message)
                    this.additional_data = null

                    let additional_response = response.data.additional_response;
                    if(additional_response){
                        this[additional_response.action](additional_response.data)
                    }
                }
            })
        },
        CheckIfResponseMeansActionOnClient() {
            if(this.current_action.client_action){
                let client_actions = this.current_action.client_action.split("|")
                client_actions.forEach((client_action) => {
                    this[client_action]();
                })
            }
        },
        ReplaceWithUserData(message) {
            let n = message.match(/{{(.*)}}/)
            if(n) {
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
            this.text = this.text.replace(new RegExp(/./, 'g'), "*");
        },
        SetUserCurrency() {
            this.user.currency = this.text
        },
        SetUserAsAdditionalData() {
            this.additional_data = JSON.stringify(this.user)
        },
        SetTransactionAsAdditionalData() {
            this.additional_data = JSON.stringify(this.transaction)
        },
        SetTransactionCurrency() {
            this.transaction.currency = this.text
        },
        SetTransactionAmount() {
            this.transaction.amount = this.text
        },
        SetInputTypeToPassword() {
            console.log('SetInputTypeToPassword')
            this.input_type = 'password';
        },
        SetInputTypeToText() {
            console.log('SetInputTypeToText')
            this.input_type = 'text';
        },
        SetToken(data) {
            if(data.token && data.user){
                localStorage.setItem("token", data.token)
                localStorage.setItem("user", JSON.stringify(data.user))
                this.user = data.user            
            }
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
        background-color: lightcoral;
    }

    .messages > .user {
        text-align: right;
        background-color: blueviolet;
    }
</style>