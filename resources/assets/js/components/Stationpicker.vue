
<template>
    <div>
        <el-select v-model="value" placeholder="Select" >
            <el-option
                    filterable
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
                value: this.defaultValue,
                loading: true,
            }
        },
        created() {
            axios.get(this.sourceUrl)
                .then(response => {
                    let stations = [];
                    for(var key in response.data){
                        stations.push(
                            {
                                value: response.data[key],
                                label: key
                            }
                        )
                    }
                    this.options = stations;
                    this.loading = false;
                })
        }
    }
</script>
