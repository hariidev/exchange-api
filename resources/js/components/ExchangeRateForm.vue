<template>
    <div class="exchange-rate-form">
        <h2>Exchange Rate Data Entry</h2>

        <button @click="logout" class="logout-button">Logout</button>

        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" v-model="form.date" required>
            </div>

            <div class="form-group">
                <label for="currency">Currency:</label>
                <select id="target_currency" v-model="form.target_currency" required>
                    <option value="USD">USD</option>
                    <option value="AUD">AUD</option>
                    <option value="CAD">CAD</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rate">Rate (LKR):</label>
                <input type="number" id="rate" v-model="form.rate" step="0.0001" required>
            </div>

            <button type="submit" :disabled="loading">{{ loading ? 'Submitting...' : 'Submit' }}</button>

            <div v-if="successMessage" class="success-message">{{ successMessage }}</div>
            <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                date: new Date().toISOString().split('T')[0],
                rate: 0
            },
            loading: false,
            successMessage: '',
            errorMessage: ''
        };
    },
    methods: {
        async submitForm() {
            this.loading = true;
            this.successMessage = '';
            this.errorMessage = '';

            try {
                await axios.post('/api/exchange-rates', this.form, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('auth_token')}`
                    }
                });
                this.successMessage = 'Exchange rate submitted successfully!';
                this.form.rate = 0;
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'An error occurred';
            } finally {
                this.loading = false;
            }
        },
        async logout() {
            try {
                await axios.post('/api/logout', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('auth_token')}`
                    }
                });
            } catch (_) { }
            localStorage.removeItem('auth_token');
            this.$router.push({ name: 'login' });
        }
    }
};
</script>

<style scoped>
.exchange-rate-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.logout-button {
    float: right;
    background: crimson;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.success-message {
    color: green;
    margin-top: 10px;
}

.error-message {
    color: red;
    margin-top: 10px;
}
</style>
