<!--   * vue: "2.5.17",
* @package FACTFOKUZ
* @author  AYUSH
* @Date   04-01-2020
* @module customer
* @Components   Add,Edit,Update
* Can Add,Edit Delete customer
* Description: customer List
-->
<template>
    <div>
        <MainHeader></MainHeader>
        <div class="container-fluid">
            <MenuBar></MenuBar>

            <div class="col-xs-12 main shop-details-main col-md-offset-1 col-lg-offset-0" v-bind:class="{
                    'col-md-9': toggle && !menu_toggle,
                    'all-menu-pinned': toggle && menu_toggle,
                    'col-md-11': !toggle,
                    'main-menu-pinned': menu_toggle
                }" @click="filter = false">
                <div class="row data-bg">
                    <div class="col-xs-12 main_msgs" id="main_msgs" role="alert">
                        <span></span>
                    </div>

                    <div class="head-main">
                        <div class="page-title colum col-xs-6 max599-w-100">
                            <h3 class="page-head pull-left">Dashboard</h3>
                            <p class="total-count pull-left">
                                <span>{{ total }}</span> Total
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div v-loading="loading">
                        <div class="table-wrapper">
                           
                            <div class="col-xs-12 customer-list-table">
                        <!--  <apexchart type="pie" width="380" :options="chartOptions" :series="series"></apexchart>
                        <apexchart type="radialBar" height="350" :options="chartOptionss" :series="seriess"></apexchart>
                             -->
                            <!--  <apexchart v-if="series[0].data.length" width="500" type="bar" :options="chartOptions" :series="series"></apexchart> -->
                        
                        <apexchart type="area" v-if="series[0].data.length" height="350" :options="chartOptions" :series="series"></apexchart>

                          <!--   <el-table
              :data="orderData"
              border
              show-summary
              v-if="orderData.length > 0"
              style="width: 100%"
            >
              <el-table-column
                prop="users.name"
                label="Category"
                width="180"
              >
              </el-table-column>
               <el-table-column
                prop="shops.shop_name"
                label="Category"
                width="180"
              >
              </el-table-column>
               <el-table-column
                prop="final_rate"
                label="Rate"
                width="180"
              >
              </el-table-column>
            
                          </el-table> -->
                           </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
</template>

<script>
    import MenuBar from  "../.././Common/Vue/menubar.vue";
    import MainHeader from "../.././Common/Vue/header.vue";
    export default {
        components: {
            MenuBar,
            MainHeader,
        },
        mounted(){
            // this.getOrderDetails();
            // this.getOrderDetailss();
            //this.getUserPerformance();
            this.getDailyPerformance();
        },
        data() {
            return {
                auth_user: [],
                loading: false,
                toggle:false,
                filter:false,
                menu_toggle:false,
                orderData:[],
         /*     
          chartOptions: {
          chart: {
            id: 'vuechart-example'
          },
          xaxis: {
            categories: []
          }
        },
        series: [{
          name: 'series-1',
          data: []
        }], */
            
          series: [{
            name: 'series1',
            data: []
          }, ],
          chartOptions: {
            chart: {
              height: 350,
              type: 'area'
            },
            dataLabels: {
              enabled: false
            },
            
            xaxis: {
             
              categories: []
            },
            
          },
          
          
            total:0,
                searchText:'',
                addFormVisible: false,
                pageNationConst: this.$pagination,
            };
        },
        methods:{
         /* getUserPerformance(){
             var app=this
                app.$axios
                .get("http://localhost/beta-fact/public/order/getUserPerformance")
                .then((response) => (
                  app.chartOptions.xaxis.categories = response.data.names,
                  app.series[0]['data'] = response.data.value
                  )
                
                )
                .catch((error) => {
                app.$message({
                    message: "List cannot be loaded",
                    type: error,
                });
                });

          },
            getOrderDetails(){
                var app=this
                app.$axios
                .get("http://localhost/beta-fact/public/order/getOrderDetails")
                .then((response) => (app.series = response.data)
                
                )
                .catch((error) => {
                app.$message({
                    message: "List cannot be loaded",
                    type: error,
                });
                });

            },
            getOrderDetailss()
            {
            var app=this
                app.$axios
                .get("http://localhost/beta-fact/public/order/getOrderDetailss")
                .then((response) => (app.seriess = response.data)
                
                )
                .catch((error) => {
                app.$message({
                    message: "List cannot be loaded",
                    type: error,
                });
                });

             }*/
        getDailyPerformance(){
          var app=this
                app.$axios
                .get("http://localhost/beta-fact/public/order/getDailyPerformance")
                .then((response) => (
                  app.series[0]['data'] = response.data.rates,

                  app.chartOptions.xaxis.categories=response.data.dates
                  )
                
                )
                .catch((error) => {
                app.$message({
                    message: "List cannot be loaded",
                    type: error,
                });
                });
        }     

        }, 
            };

</script>
