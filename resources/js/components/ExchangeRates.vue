<template>
    <div class="exchange-rates">
        <h2>Exchange Rates (USD to LKR)</h2>

        <div class="date-picker">
            <label for="date">Select Date:</label>
            <input type="date" id="date" v-model="selectedDate" @change="fetchRates">
        </div>

        <div v-if="loading" class="loading">Loading...</div>

        <div v-else>
            <table class="rates-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rate, index) in rates" :key="index">
                        <td>{{ rate.date }}</td>
                        <td>{{ parseFloat(rate.rate).toFixed(4) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="summary">
                <p><strong>Current Rate:</strong> {{ currentRate ? currentRate.toFixed(4) : 'N/A' }}</p>
                <p><strong>Weekly Average:</strong> {{ weeklyAverage ? weeklyAverage.toFixed(4) : 'N/A' }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            selectedDate: new Date().toISOString().split('T')[0],
            rates: [],
            currentRate: 0,
            weeklyAverage: 0,
            loading: false
        };
    },
    mounted() {
        this.fetchRates();
    },
    methods: {
        async fetchRates() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/usd-rates?date=${this.selectedDate}`);
                console.log(response);
                this.rates = response.data.data;
                this.currentRate = parseFloat(response.data.meta.current_rate) || 0;
                this.weeklyAverage = parseFloat(response.data.meta.average_rate) || 0;
            } catch (error) {
                console.error('Error fetching rates:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>
.exchange-rates {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.date-picker {
    margin-bottom: 20px;
}

.rates-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.rates-table th,
.rates-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.rates-table th {
    background-color: #f2f2f2;
}

.summary {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.loading {
    text-align: center;
    padding: 20px;
}
</style>