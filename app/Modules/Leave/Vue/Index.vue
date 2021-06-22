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
                            <h3 class="page-head pull-left">Leave List</h3>
                            <p class="total-count pull-left">
                                <span>{{ total }}</span> Total
                            </p>
                        </div>
                        <div class="input-field colum col-xs-6 max599-w-100 text-right head-icons">
                            <div class="common-search">
                                <el-input class="search-keyword" placeholder="Search" @clear="searchDB()" clearable v-model="searchText"></el-input>

                                <el-button @click="searchDB()" icon="icon-search"></el-button>
                            </div>
                            <el-tooltip content="Add" placement="bottom" effect="light">
                                <el-button @click="addFormVisible = true" class="el-icon-plus custom-btn add-btn"></el-button>
                            </el-tooltip>
                            <el-button class="icon custom-btn filter-btn ml-5" v-on:click.stop v-on:click.exact="filter = true">
                                <i class="btn-icon icon icon-filter"></i> Filter
                            </el-button>
                        </div>
                    </div>
                    <div class="filter-bg" v-bind:class="{ show: filter }" @click="filter = false"></div>
                    <div class="filter-div" v-bind:class="{ width: filter }" v-on:click.stop>
                        <div class="filter-head">
                            <h4 class="pull-left">Filter</h4>
                            <a class="filter-close pointer el-icon-close pull-right" @click="filter = false"></a>
                        </div>
                            <div class="col-xs-12">
                                <el-input placeholder="Search" name="searchText" v-model="searchText" clearable></el-input>
                            </div>

                        <div class="filter-footer col-xs-12 text-right">
                            <el-button v-on:click="clearSearch()">Clear</el-button>
                            <el-button type="primary" v-on:click="
                                    page = 1;
                                    searchDB();
                                ">Filter</el-button>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="filter-items-main col-xs-12">
                        
                        <div class="filter-items" v-if="searchText">
                            {{ searchText }}
                            <span class="el-icon-close pull-right pointer" @click="
                                    searchText = '';
                                    searchDB();
                                "></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div v-loading="loading">
                        <div class="table-wrapper">
                            <div class="col-xs-12 customer-list-table">
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <Add :addFormVisible.sync="addFormVisible" ></Add>
    </div>
</template>

<script>
    import MenuBar from  "../.././Common/Vue/menubar.vue";
    import MainHeader from "../.././Common/Vue/header.vue";
    import Add from "./Components/Add.vue";
    export default {
        components: {
            MenuBar,
            MainHeader,
            Add
        },
        data() {
            return {
                auth_user: [],
                loading: false,
                toggle:false,
                filter:false,
                menu_toggle:false,
                total:0,
                searchText:'',
                addFormVisible: false,
                pageNationConst: this.$pagination,
            };
        },
    };

</script>
