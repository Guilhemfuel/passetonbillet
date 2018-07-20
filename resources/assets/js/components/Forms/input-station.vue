<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="selected"
        >

        <!-- With Icon -->

        <div :class="{'animated pulse':pulse&&errors.has(name),'icon-form':true}" v-if="withIcon">
            <i class="fa fa-map-marker text-primary" aria-hidden="true"></i>
            <el-select v-model="selected" placeholder="Select"
                       :class="{'invalid':errors.has(name)}"
                       :remote-method="remoteMethod"
                       :loading="loading"
                       :placeholder="placeholder"
                       filterable
                       remote
            >
                <el-option
                        v-for="station in stations"
                        :key="station.id"
                        :label="station.name"
                        :value="station.id">
                    {{station.name}}
                </el-option>
            </el-select>
        </div>

        <!-- Without Icon -->

        <el-select v-else v-model="selected" placeholder="Select"
                   :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                   :remote-method="remoteMethod"
                   :loading="loading"
                   :placeholder="placeholder"
                   filterable
                   remote
        >
            <el-option
                    v-for="station in stations"
                    :key="station.id"
                    :label="station.name"
                    :value="station.id">
                {{station.name}}
            </el-option>
        </el-select>

        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    export default {
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            defaultValue: {required: false, type: String},
            withIcon: {required: false, default: true, type: Boolean},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
        },
        computed: {
            getClass() {
                return this.className ? ('form-group input-station ' + this.className) : 'form-group input-station';
            },
            pulse() {
                return this.$parent.pulse;
            }
        },
        data() {
            return {
                loading: false,
                currency: this.defaultValue,
                stations: [],
                selected: null,
                sourceUrl: '/api/stations/search',
            }
        },
        methods: {
            remoteMethod(query) {
                if (query !== '') {
                    this.loading = true;
                    this.$http.get(this.sourceUrl + '?name=' + query)
                        .then(response => {
                            this.stations = response.data.data;
                            this.loading = false;
                        })
                }
            }
        }
    }
</script>
