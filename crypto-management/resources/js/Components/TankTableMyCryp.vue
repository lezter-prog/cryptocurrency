<script setup>

import {
  FlexRender,
  getCoreRowModel,
  useVueTable
} from '@tanstack/vue-table';
import { ref,h } from 'vue';
import BuySellButton  from '@/Components/BuySellButton.vue';
import { usePage } from '@inertiajs/vue3';


defineProps({
    tableData:{
        type: Object
    },
    tableColumns:{
        type: Object,
    },
    type:{
        type: String,
    }
});


const tableData = ref(usePage().props.tableData);

const module =  ref(usePage().props.type);
console.log(module.value);
const columnsCrypto =ref([
    {
        accessorKey:'name',
        header:'Name'
    },
    {
        accessorKey:'quantity',
        header:'Quantity'
    },
    {
        accessorKey:'bought_price',
        header:'Bought Price',
        cell:({row})=>  {
            return h('div', {
                class:'w-full text-center ',
                innerHTML: '€'+row.original.bought_price
            })
        }
    },
    
    {
        accessorKey:'current_price',
        header:'Current Price',
        cell:({row})=>  {
            return h('div', {
                class:'w-full text-center ',
                innerHTML: '€'+row.original.current_price
            })
        }
    },
    {
        accessorKey:'total_bought_amount',
        header:'Total Bought Amount',
        cell:({row})=>  {
            return h('div', {
                class:'w-full text-center ',
                innerHTML: '€'+row.original.total_bought_amount.toFixed(2)
            })
        }
    },
    {
        accessorKey:'total_amount_gain',
        header:'Total Selling Amount',
        cell:({row})=>  {
            var totalAmount = row.original.current_price*row.original.quantity;
            return h('div', {
                class:'w-full text-center ',
                innerHTML: '€'+totalAmount.toFixed(2)
            })
        }
    },
    {
        accessorKey:'gain_loss',
        header:'Gain/Loss',
        cell:({row})=>  {
            var totalAmount = row.original.current_price*row.original.quantity;
            var crypt =row.original; 
            var diff =((totalAmount+row.original.sold_amount) - crypt.total_bought_amount );
            var gain_loss =(diff/crypt.bought_price) *100;
            var textColor = gain_loss>=0?'text-green-400':'text-red-500';
                 
            return h('div', {
                class:'w-full text-center '+textColor,
                innerHTML: gain_loss.toFixed(2)+"%"
            })
        }
    },
    {
        accessorKey:'sold_amount',
        header:'Sold Amount',
        cell:({row})=>  row.original.sold_amount==null?0:row.original.sold_amount.toFixed(2)
    },
    {
        accessorKey:'id',
        header:' ',
        cell:({row})=>  h(BuySellButton,{
            id:row.original.crypto_id,
            code:row.original.code,
            cryptName:row.original.name,
            cryptPrice:row.original.current_price,
            boughtPrice:row.original.bought_price,
            quantity:row.original.quantity,
            totalBoughtAmount:row.original.total_bought_amount
        })
    }
    
]);


const table = useVueTable({
    data:tableData.value,
    columns: columnsCrypto.value,
    getCoreRowModel:getCoreRowModel()
})




</script>

<template>
     <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 ">
                        <tr v-for="headerGroup  in table.getHeaderGroups()" :key="headerGroup.id">
                            <th v-for="header in headerGroup.headers" :key="header.id" scope="col" class="px-6 py-3">
                                <FlexRender :render="header.column.columnDef.header" :props="header.getContext()"/>
                            </th>  
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in table.getRowModel().rows" 
                        :key="row.index" 
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td v-for="cell in row.getVisibleCells()" 
                            :key="cell.id" 
                            :class="{'text-center':(typeof cell.getValue() == 'number')}" 
                            class="px-6 py-4" >
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext( )" :key="cell.index"/>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
</template>