<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="selected"
               v-if="name"
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
                       @change="emitChange"

            >
                <el-option
                        v-for="station in stations"
                        :key="station.id"
                        :label="station.name"
                        :value="station.id"
                        class="input-station-option">
                    {{station.name}} <span class="specific-name"
                                           v-if="station.name_country_specific">({{station.name_country_specific}})</span>
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
                   @change="emitChange"

        >
            <el-option
                    v-for="station in stations"
                    :key="station.id"
                    :label="station.name"
                    :value="station.id"
                    class="input-station-option"
            >
                {{station.name}} <span class="specific-name"
                                       v-if="station.name_country_specific">({{station.name_country_specific}})</span>
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
            name: {required: false, type: String},
            defaultValue: {required: false},
            withIcon: {required: false, default: true, type: Boolean},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            oldValue: {required: false, type: Boolean, default: true},
        },
        computed: {
            getClass() {
                return this.className ? ('form-group input-station ' + this.className) : 'form-group input-station';
            },
            pulse() {
                return this.$parent.pulse;
            },
            defaultVal() {
                if (this.defaultValue != null && this.defaultValue != undefined) {
                    return this.defaultValue;
                }
                if (this.oldValue && this.$root.oldInput[this.name]) {
                    return this.$root.oldInput[this.name];
                }
                return null;
            }
        },
        data() {
            return {
                loading: false,
                stations: [],
                selected: null,
                sourceUrl: this.route('api.stations.search'),
            }
        },
        mounted() {
            let defaultId = this.defaultVal;

            if (defaultId != null) {
                this.loading = true;

                this.$http.get(this.route('api.stations.show', [defaultId]))
                    .then(response => {
                        this.stations = [response.data.data];
                        this.loading = false;
                        this.selected = parseInt(defaultId);
                    })
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
            },
            emitChange(value) {
                this.$emit('change',value);
            }
        },
        watch: {
            defaultVal () {
                this.loading = true;

                this.$http.get(this.route('api.stations.show', [this.defaultVal]))
                    .then(response => {
                        this.stations = [response.data.data];
                        this.loading = false;
                        this.selected = parseInt(this.defaultVal);
                    })
            }
        }

    }
</script>
