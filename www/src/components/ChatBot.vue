<template>
    <b-container>
        <b-row>
            <b-col md="8" offset-md="2" xs="12">
                <ul class="messages">
                    <li :class="{'user': message.is_from_user, 'bot': !message.is_from_user}" v-for="(message, index) in messages" :key="index">
                        <p class="title">{{message.is_from_user ? user.name : "Jobsity Bot"}}</p>
                        <p class="message">{{message.text}}</p>
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
                    <b-form-input type="text" @keyup.enter="Send" v-model="text" />
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
export default {
    data() {
        return {
            messages: [],
            user: {
                name: "Thiago"
            },
            text: ""
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
            let message = {
                text: this.text,
                is_from_user: true
            }
            this.messages.push(message)
            this.text = ''
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
        background-color: blue;
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
    }

    .messages > .user {
        text-align: right;
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