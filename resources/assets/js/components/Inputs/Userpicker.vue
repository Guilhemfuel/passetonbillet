
<template>
    <div>
        <el-select
                v-model="value"
                filterable
                remote
                placeholder="Please enter a keyword"
                :remote-method="remoteMethod"
                :loading="loading"
                :placeholder="defaultPlaceholder">
            <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                    :loading="loading">
            </el-option>
        </el-select>
        <input type="hidden" :name="nameInput" :value="value"/>
    </div>
</template>

<script>

    export default {
        props: {
            name:null,
            defaultValue: null,
            defaultPlaceholder: null,
            url: null,
        },
        created(){
            if(this.defaultValue == null) return;
            var item = {
                label: this.defaultValue.first_name+' '+this.defaultValue.last_name,
                value: this.defaultValue.id
            };
            this.options = [item];
            this.value = item.value;
        },
        data() {
            return {
                nameInput: this.name || "user_id",
                placeholder: this.defaultPlaceholder || 'User name',
                value:  null,
                loading: false,
                options: [],
                sourceUrl: this.url || '/api/users/',
            }
        },
        methods: {
            remoteMethod(query) {
                if (query !== '') {
                    this.loading = true;
                    setTimeout(() => {
                        this.$http.get(this.sourceUrl+query)
                            .then(response => {
                                this.options = response.data;
                            })
                        this.loading = false;
                    }, 400);
                } else {
                    this.options = [];
                }
            },
        }
    }
</script>
