<template>
    <div class="auth-form">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            error: ''
        };
    },
    methods: {
        async login() {
            this.error = '';
            try {
                const res = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                });
                localStorage.setItem('auth_token', res.data.token);
                this.$router.push({ name: 'exchange-rate-form' });
            } catch (err) {
                this.error = 'Invalid credentials';
            }
        }
    }
};
</script>

<style scoped>
.auth-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

input {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #4caf50;
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
}

button:disabled {
    background-color: #999;
    cursor: not-allowed;
}

.error-message {
    color: red;
    margin-top: 10px;
    text-align: center;
}

.form-link {
    text-align: center;
    margin-top: 15px;
}
</style>