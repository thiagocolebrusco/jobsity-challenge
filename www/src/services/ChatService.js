import http from './http'

let ChatService = {
    Send(message) {
        return http.post("send", message);
    }
}

export default ChatService