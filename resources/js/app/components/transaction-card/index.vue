<template>
    <v-card
        color="#385F73"
        dark
        class="my-4"
    >
        <v-card-title class="text-h6">
            {{ item.payer ? item.payer.name : ''  }}
        </v-card-title>

        <v-list class="transparent" dense>

            <v-list-item>
                <v-list-item-title class="text-body-1">Amount with vat</v-list-item-title>
                <v-list-item-subtitle class="text-body-1">
                    {{ item.amount_with_vat }}
                </v-list-item-subtitle>

            </v-list-item>

            <v-list-item>
                <v-list-item-title class="text-body-1">Amount</v-list-item-title>
                <v-list-item-subtitle  class="text-body-1">
                    {{ item.amount }}
                </v-list-item-subtitle>
            </v-list-item>

            <v-list-item>
                <v-list-item-title class="text-body-1">Vat amount</v-list-item-title>
                <v-list-item-subtitle class="text-body-1">
                    {{ item.vat_amount }}
                </v-list-item-subtitle>
            </v-list-item>

            <v-list-item>
                <v-list-item-title class="text-body-1">Total Paid Amount</v-list-item-title>
                <v-list-item-subtitle class="text-body-1">
                    {{ item.total_paid_amount }}
                </v-list-item-subtitle>
            </v-list-item>

            <v-list-item>
                <v-list-item-title class="text-body-1">Status</v-list-item-title>
                <v-list-item-subtitle class="text-body-1">
                    {{ item.status_text }}
                </v-list-item-subtitle>
            </v-list-item>

            <v-list-item>
                <v-list-item-title class="text-body-1">Due On</v-list-item-title>
                <v-list-item-subtitle class="text-body-1">
                    {{ item.due_on }}
                </v-list-item-subtitle>
            </v-list-item>

        </v-list>

    </v-card>
</template>

<script>
export default {
    name: "TaskCard",
    props: {
        item: {
            type: Object
        }
    }
}
</script>

<style scoped>

</style>
