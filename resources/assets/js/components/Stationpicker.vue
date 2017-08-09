
<template>
    <div>
        <el-select v-model="value" placeholder="Select" filterable>
            <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                    :loading="loading"
                   >
            </el-option>
        </el-select>
        <input type="hidden" :name="nameInput" :value="value"/>
    </div>
</template>

<script>

    export default {
        props: {
            name:null,
            placeholder:null,
            url:null,
            defaultOptions: null,
            defaultValue: null
        },
        data() {
            return {
                nameInput: this.name || "station_id",
                placeholderInput: this.placeholder || "Station",
                sourceUrl: this.url || '/api/stations',
                options: this.defaultOptions || [],
                value: null,
                loading: true,
                selectedItem: this.defaultValue
            }
        },
        created() {
            axios.get(this.sourceUrl)
                .then(response => {
                    let stations = [];
                    for(var key in response.data){

                        if (this.selectedItem == response.data[key]){
                            this.selectedItem = {
                                value: response.data[key],
                                    label: key
                            }
                        }
                        stations.push(
                            {
                                value: response.data[key],
                                label: key
                            }
                        )
                    }
                    this.options = stations;
                    this.loading = false;
                    this.value = this.selectedItem.value;

                })

        }
    }
</script>
