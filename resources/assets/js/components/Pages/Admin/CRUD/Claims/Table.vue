<template>
    <div>
        <el-table
                class="table table-striped"
                ref="ticketsTable"
                :data="searchedClaims"
                max-height="650"
                style="width: 100%"
        >

            <el-table-column
                    prop="date_claim"
                    sortable
                    label="Date Claim"
            >
            </el-table-column>

            <el-table-column
                    label="Seller"
                    sortable
                    prop="seller.full_name"
            >
                <template slot-scope="scope">
                    <a :href="scope.row.seller_link">{{ scope.row.seller.full_name }}</a>
                </template>
            </el-table-column>

            <el-table-column
                    label="Purchaser"
                    sortable
                    prop="purchaser.full_name"
            >
                <template slot-scope="scope">
                    <a :href="scope.row.purchaser_link">{{ scope.row.purchaser.full_name }}</a>
                </template>
            </el-table-column>
            <el-table-column
                    prop="departure_date"
                    label="Date"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="departure_city"
                    label="From"
            >
            </el-table-column>
            <el-table-column
                    prop="arrival_city"
                    label="To"
            >
            </el-table-column>
            <el-table-column
                    prop="status_claim"
                    label="Status"
            >
            </el-table-column>

            <el-table-column
                    label="Actions"
                    fixed="right"

            >
                <template slot-scope="scope">
                    <a class="btn btn-sm btn-info btn-fill" :href="scope.row.show_link">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
  export default {
    props: {
      claims: {required: true},
    },
    data() {
      return {

      }
    },
    methods: {

    },
    computed: {
      searchedClaims() {
        let filtered = [];
        for (let i = 0; i < this.claims.length; i++) {
          if (true) {
            filtered.push(this.claims[i]);
          }
        }
        return filtered;
      }
    },
    mounted() {
      console.log(this.claims);
    }
  }
</script>
