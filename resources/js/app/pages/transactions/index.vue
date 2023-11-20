<template>
    <v-container>
        <v-row dense class="justify-content-center">
            <v-col cols="4"></v-col>
            <v-col cols="4">
                <h1 class="my-6">{{ this.$store.state.isAdmin ?  'Customers Transactions' : 'My Transactions' }}</h1>
                <transaction-card v-for="item in items" :key="item.id" :item="item"/>
            </v-col>
        </v-row>
        <div class="text-xs-center mt-6 mb-10">
            <v-pagination
                v-if="items.length > 0 && pagination.last_page > 1"
                v-model="pagination.current_page"
                :length="pagination.last_page"
                :total-visible="10"
                @input="getTransactions"
            ></v-pagination>
        </div>
    </v-container>
</template>

<script>
import TransactionCard from '../../components/transaction-card'
import {getTransactionsForAdmin, getTransactionsForCustomer} from "../../api/transactions";

export default {
    name: "Tasks",
    components: {
        TransactionCard:TransactionCard
    },
    data: () => ({
        items: [],
        loading:false,
        pagination: {},
    }),
    watch: {
        "$route.query"() {
            this.getTransactions();
        },
    },
    mounted () {
        this.getTransactions();
    },

    methods: {
        getTransactions(page = 1) {
            this.loading = true;
            let getTransaction = this.$store.state.isAdmin ? getTransactionsForAdmin : getTransactionsForCustomer;
            getTransaction(page).then(res => {
                this.items = res.data.data;
                this.pagination = res.data.meta;
            }).catch(err => {
                console.log(err)
            }).finally(() => (this.loading = false))
        },
    }
}
</script>

<style scoped>

</style>
