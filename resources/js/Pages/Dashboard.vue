<template>
    <Head title="Dashboard" />
    <div class="bg-gray-200 h-screen">
        <div class="text-center pt-4">
            <div class="border-2 inline-block px-3 py-1 m-4 relative border-black w-11/12 pb-9 rounded">
                <div class="mt-4 grid grid-cols-1 gap-x-12 gap-y-5 grid-cols-6 px-7">
                    <div class="col-span-3 ">
                        <label for="host" class="block text-sm font-medium leading-6 text-left text-black ml-1">Database
                            Host (Port
                            defaults to 3306)</label>
                        <div class="mt-2">
                            <input type="text" name="host" id="host" v-model="data['db_host']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-left text-black ml-1">Database
                            Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" v-model="data['db_name']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="db_username"
                            class="block text-sm font-medium leading-6 text-left text-black ml-1">Database
                            Username</label>
                        <div class="mt-2">
                            <input type="text" name="db_username" id="db_username" v-model="data['db_username']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="db_password"
                            class="block text-sm font-medium leading-6 text-left text-black ml-1">Database
                            Password</label>
                        <div class="mt-2">
                            <input type="password" name="db_password" id="db_password" v-model="data['db_password']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="country" class="block text-sm font-medium leading-6 text-left text-black ml-1">Database
                            Driver</label>
                        <div class="mt-2">
                            <select id="driver" name="driver" v-model="data['db_driver']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                                <option value="mysql">MySQL</option>
                                <option value="pgsql">PostgreSQL</option>
                                <option value="sqlite">SQLite</option>
                                <option value="sqlsrv">Microsoft SQL Sever</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 inline-block p-1 rounded absolute -top-5 left-2 text-black">MySQL Data</div>
            </div>
        </div>
        <div class="text-center pt-4">
            <div class="border-2 inline-block px-3 py-1 m-4 relative border-black w-11/12 pb-5 rounded">
                <div class="mt-4 px-7">
                    <label for="query" class="block text-md font-medium leading-6 text-left text-black ml-1">Only select
                        queries are accepted.</label>
                    <div class="mt-2">
                        <textarea id="query" name="query" rows="5" v-model="data['db_query']"
                            class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"></textarea>
                    </div>
                    <button
                        class="block px-4 py-2 mt-5 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        @click="search" :disabled="loading">Search</button>
                </div>
                <div class="bg-gray-200 inline-block p-1 rounded absolute -top-5 left-2 text-black">MySQL Query</div>
            </div>
        </div>
        <div class="bg-gray-200 text-center pt-4" v-if="showParameters">
            <div class="border-2 inline-block px-3 py-1 m-4 relative border-black w-11/12 pb-9 rounded px-9">
                <div class="mt-4 grid grid-cols-1 gap-x-12 gap-y-5 grid-cols-6">
                    <div class="col-span-3 ">
                        <div class="flex align-center">
                            <div class="flex items-center">
                                <input id="splitBy" type="radio" value="category" name="splitBy"
                                    v-model="parameters['splitBy']"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2">
                            </div>
                            <div class="ms-2 text-sm text-left">
                                <label for="split-by" class="font-medium text-black">Plot data by category</label>
                                <p id="split-by-text" class="text-xs font-normal text-gray-500 text-black">
                                    For data that is split by unique category id. (uses single column)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3 ">
                        <div class="flex align-center">
                            <div class="flex items-center">
                                <input id="splitBy" type="radio" value="column" name="splitBy"
                                    v-model="parameters['splitBy']"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 ">
                            </div>
                            <div class="ms-2 text-sm text-left">
                                <label for="helper-radio" class="font-medium text-black">Plot data by columns</label>
                                <p id="helper-radio-text" class="text-xs font-normal text-gray-500 text-black">
                                    For data that has separate columns to categorize. (single or multiple columns)</p>
                            </div>
                        </div>
                    </div>
                    <template v-if="parameters['splitBy'] === 'category'">
                        <div class="col-span-3">
                            <label for="category"
                                class="block text-sm font-medium leading-6 text-left text-black ml-1">Category
                                Column</label>
                            <div class="mt-2">
                                <select id="category" name="category" v-model="parameters['categoryColumn']"
                                    class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                                    <option v-for="column in columns" :key="column" :value="column">{{ column }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-3">
                            <label for="plot-value"
                                class="block text-sm font-medium leading-6 text-left text-black ml-1">Value
                                to plot</label>
                            <div class="mt-2">
                                <select id="plot-value" name="plot-value" v-model="parameters['valueToPlot']"
                                    class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                                    <option v-for="column in columns" :key="column" :value="column">{{ column }}</option>
                                </select>
                            </div>
                        </div>
                    </template>
                    <template v-if="parameters['splitBy'] === 'column'">
                        <div class="col-span-full">
                            <label for="category"
                                class="block text-sm font-medium leading-6 text-left text-black ml-1">Select columns to
                                plot</label>
                            <div class="mt-2">
                                <div class="flex">
                                    <div class="flex items-center me-4" v-for="column in columns" :key="column">
                                        <input :id="`inline-checkbox-${column}`" type="checkbox"
                                            v-model="parameters['columns'][column]"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label :for="`inline-checkbox-${column}`"
                                            class="ms-2 text-sm font-medium text-black">{{ column
                                            }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="col-span-3">
                        <label for="m-axis" class="block text-sm font-medium leading-6 text-left text-black ml-1">Main
                            Axis</label>
                        <div class="mt-2">
                            <select id="m-axis" name="m-axis" v-model="parameters['mainAxis']"
                                class="block w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6">
                                <option v-for="column in columns" :key="column" :value="column">{{ column }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button
                    class="block px-4 py-2 mt-5 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    @click="setGraph" :disabled="loading">Visualise Data</button>
                <div class="bg-gray-200 inline-block p-1 rounded absolute -top-5 left-2 text-black">Query Visualization
                    Parameters</div>
            </div>
            <div class="border-2 inline-block px-3 py-1 m-4 relative border-black w-11/12 pb-9 rounded px-9"
                v-if="showGraph">
                <div class="mt-5 p-2 bg-white rounded min-h-80">
                    <Line :data="chart" :options="options" />
                </div>
                <div class="bg-gray-200 inline-block p-1 rounded absolute -top-5 left-2 text-black">Query Visualization
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

import { Head } from '@inertiajs/vue3';
import { Line } from 'vue-chartjs'

import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)
export default {
    name: 'Dashboard',
    data() {
        return {
            loading: false,
            error: false,
            showParameters: false,
            showGraph: false,
            columns: [],
            records: [],
            colors: [
                'blue', 'red', 'green', 'yellow', 'purple', 'pink'
            ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
            data: {
                db_driver: 'mysql',
                db_host: '65816e9d.dorsy.net',
                db_name: 'd03f00ee',
                db_username: 'd03f00ee',
                db_password: 'QvCX34R8tqVEBm77Zmdu',
                db_query: 'SELECT * FROM `d03f00ee`.`Daily_Account_Balance` LIMIT 10;',
            },
            parameters: {
                splitBy: 'column',
                categoryColumn: '',
                columns: {},
                mainAxis: '',
                valueToPlot: ''
            },
            chart: {}
        }
    },
    components: {
        Head,
        Line
    },
    methods: {
        search() {
            this.refresh()
            this.loading = true
            axios.post('search', this.data)
                .then((res) => {
                    this.loading = false
                    this.prepareGraph(res.data)
                })
                .catch((err) => {
                    this.loading = false
                    this.error = true
                })
        },
        prepareGraph(data) {
            this.columns = Object.keys(data.results[0])
            this.records = data.results
            this.showParameters = true
        },
        setGraph() {
            let data = [];
            const mainAxisValues = new Set()

            // Extract the raw column values from the data.
            this.records.forEach((ele) => {
                const record = Object.values(ele)
                data.push(record)

                // Get unique Main axis values
                mainAxisValues.add(ele[this.parameters.mainAxis])
            })

            // Set the lables
            this.chart.labels = Array.from(mainAxisValues)

            // Handles the plot by Category
            if (this.parameters.splitBy === 'category') {
                var groupedData = this.records.reduce((result, item) => {
                    const group = item[this.parameters.categoryColumn]
                    records[group] = records[group] || [];
                    result[group].push(item[this.parameters.valueToPlot]);
                    return result
                }, {})
            }

            // Handles the plot by Column
            if (this.parameters.splitBy === 'column') {
                const selectedColumns = Object.keys(this.parameters.columns).filter(key => this.parameters.columns[key] === true)
                var groupedData = this.records.reduce((records, record) => {
                    selectedColumns.forEach(key => {
                        records[key] = records[key] || [];
                        records[key].push(record[key]);
                    });
                    return records;
                }, {});
            }

            // Apply the final dataset to the chart
            const dataSet = []
            Object.keys(groupedData).forEach((ele, index) => {
                const obj = {
                    label: ele,
                    data: groupedData[ele],
                    backgroundColor: this.colors[index]
                }
                dataSet.push(obj)
            })
            this.chart.datasets = dataSet
            this.showGraph = true
        },
        refresh() {
            // Resest the application to it's initial state.
            this.showGraph = false;
            this.showParameters = false;
            this.records = [];
            this.parameters = {
                splitBy: 'column',
                categoryColumn: '',
                columns: {},
                mainAxis: '',
                valueToPlot: ''
            };
        }
    }
}
</script>
