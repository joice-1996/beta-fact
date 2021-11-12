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

      <div
        class="col-xs-12 main shop-details-main col-md-offset-1 col-lg-offset-0"
        v-bind:class="{
          'col-md-9': toggle && !menu_toggle,
          'all-menu-pinned': toggle && menu_toggle,
          'col-md-11': !toggle,
          'main-menu-pinned': menu_toggle,
        }"
        @click="filter = false"
      >
        <div class="row data-bg">
          <div class="col-xs-12 main_msgs" id="main_msgs" role="alert">
            <span></span>
          </div>

          <div class="head-main">
            <div class="page-title colum col-xs-6 max599-w-100">
              <h3 class="page-head pull-left">Order List</h3>
              <p class="total-count pull-left">
                <span>{{ total }}</span> Total
              </p>
            </div>
            <div
              class="
                input-field
                colum
                col-xs-6
                max599-w-100
                text-right
                head-icons
              "
            >
              <div class="common-search">
                <el-input
                  class="search-keyword"
                  placeholder="Search"
                  @clear="searchDB()"
                  clearable
                  v-model="searchText"
                ></el-input>

                <el-button @click="searchDB()" icon="icon-search"></el-button>
              </div>

              <el-button
                class="icon custom-btn filter-btn ml-5"
                v-on:click.stop
                v-on:click.exact="filter = true"
              >
                <i class="btn-icon icon icon-filter"></i> Filter
              </el-button>
              <el-tooltip content="Add" placement="bottom" effect="light">
                <el-button
                  @click="addOrderFormVisible = true"
                  class="el-icon-plus custom-btn add-btn"
                ></el-button>
              </el-tooltip>
            </div>
          </div>
          <div
            class="filter-bg"
            v-bind:class="{ show: filter }"
            @click="filter = false"
          ></div>
          <div
            class="filter-div"
            v-bind:class="{ width: filter }"
            v-on:click.stop
          >
            <div class="filter-head">
              <h4 class="pull-left">Filter</h4>
              <a
                class="filter-close pointer el-icon-close pull-right"
                @click="filter = false"
              ></a>
            </div>
            <div class="col-xs-12">
              <el-input
                placeholder="Search"
                name="searchText"
                v-model="searchText"
                clearable
              ></el-input>
            </div>

            <div class="filter-footer col-xs-12 text-right">
              <el-button v-on:click="clearSearch()">Clear</el-button>
              <el-button
                type="primary"
                v-on:click="
                  page = 1;
                  searchDB();
                "
                >Filter</el-button
              >
            </div>
          </div>

          <div class="clearfix"></div>
          <div class="filter-items-main col-xs-12">
            <div class="filter-items" v-if="searchText">
              {{ searchText }}
              <span
                class="el-icon-close pull-right pointer"
                @click="
                  searchText = '';
                  searchDB();
                "
              ></span>
            </div>
          </div>
          <div class="clearfix"></div>
          <br />
          <div v-loading="loading">
            <div class="table-wrapper">
              <div class="col-xs-12 customer-list-table">
                <el-table
                  :data="orders"
                  border
                  show-summary
                  v-if="orders.length > 0"
                  style="width: 100%"
                >
                  <el-table-column
                    prop="order_code"
                    label="Order Code"
                    width="180"
                  >
                  </el-table-column>
                  <el-table-column
                    prop="shops.shop_name"
                    label="Shop Name"
                    width="180"
                  >
                  </el-table-column>
                  <el-table-column
                    prop="shops.districts.distrcit_name"
                    label="District"
                    width="180"
                  >
                  </el-table-column>
                  <el-table-column prop="users.name" label="User" width="180">
                  </el-table-column>
                  <el-table-column
                    prop="final_rate"
                    label="Total Rate"
                    width="180"
                  >
                  </el-table-column>
                  <el-table-column
                    prop="created"
                    label="Order Date"
                    width="180"
                  >
                  </el-table-column>
                  <el-table-column prop="Action" label="Action" min-width="100">
                    <template slot-scope="scope">
                      <el-button
                        type="button"
                        @click="
                          delete_id = scope.row._id;
                          deleteFormVisible = true;
                        "
                        >Delete
                      </el-button>
                      <el-button 
                        type="button" 
                        @click="
                          edit_id = scope.row._id;
                          editFormVisible=true;"
                        >Edit
                      </el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Add
      :addOrderFormVisible.sync="addOrderFormVisible"
      :users="users"
      :districts="districts"
      :categories="categories"
    ></Add>
    <Delete
      :deleteFormVisible.sync="deleteFormVisible"
      :getOrders="getOrders"
      :delete_id="delete_id"
    ></Delete>
    <Edit
      :editFormVisible.sync="editFormVisible"
      :getOrders="getOrders"
      :users="users"
      :categories="categories"
      :edit_id="edit_id"
    ></Edit>
  </div>
</template>

<script>
import MenuBar from "../.././Common/Vue/menubar.vue";
import MainHeader from "../.././Common/Vue/header.vue";
import Add from "./Components/addOrder.vue";
import Delete from "./Components/deleteOrder.vue";
import Edit from "./Components/editOrder.vue";
export default {
  components: {
    MenuBar,
    MainHeader,
    Add,
    Delete,
    Edit
  },
  mounted() {
    this.getUsers();
    this.getCategories();
    this.getDistricts();
    this.getOrders();
  },
  data() {
    return {
      auth_user: [],
      users: [],
      categories: [],
      districts: [],
      orders: "",
      loading: false,
      toggle: false,
      filter: false,
      menu_toggle: false,
      total: 0,
      searchText: "",
      addOrderFormVisible: false,
      deleteFormVisible: false,
      editFormVisible:false,
      pageNationConst: this.$pagination,
      edit_id: "",
      delete_id: "",
    };
  },
  methods: {
    getUsers() {
      var app = this;
      app.$axios
        .get("http://localhost/beta-fact/public/order/getUsers")
        .then((response) => (app.users = response.data))
        .catch((error) => {
          app.$message({
            message: "List cannot be loaded",
            type: error,
          });
        });
    },
    getDistricts() {
      var app = this;
      app.$axios
        .get("http://localhost/beta-fact/public/order/getDistricts")
        .then((response) => (app.districts = response.data))
        .catch((error) => {
          app.$message({
            message: "List cannot be loaded",
            type: error,
          });
        });
    },
    getCategories() {
      var app = this;
      app.$axios
        .get("http://localhost/beta-fact/public/order/getCategories")
        .then((response) => (app.categories = response.data))
        .catch((error) => {
          app.$message({
            message: "List cannot be loaded",
            type: error,
          });
        });
    },
    getOrders() {
      var app = this;
      app.$axios
        .get("http://localhost/beta-fact/public/order/getOrders")
        .then((response) => (app.orders = response.data))
        .catch((error) => {
          app.$message({
            message: "List cannot be loaded",
            type: error,
          });
        });
    },
  },
};
</script>
