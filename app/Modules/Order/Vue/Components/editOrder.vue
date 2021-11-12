<template>
  <div>
    <transition name="drawer-transition">
      <div
        v-show="editFormVisible"
        class="col-xs-12 col-md-4 col-lg-3 drawer-div"
      >
        <div class="drawer-head">
          <div class="row">
            <h4 class="col-xs-10">{{ pageName }}</h4>
            <span class="col-xs-2">
              <a @click="closeDialog()" class="drawer-close-btn">X</a>
            </span>
          </div>
        </div>
        <ValidationObserver v-slot="{ invalid }" ref="editform">
          <div class="popup-scroll">
            <el-form :model="form_data" ref="editForm">
              <el-form-item label="Select User*">
                <ValidationProvider
                  name="User"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <el-select
                    v-model="form_data.user_id"
                    clearable
                    placeholder="Select"
                  >
                    <el-option
                      v-for="val in users"
                      :key="val._id"
                      :label="val.name"
                      :value="val._id"
                    >
                    </el-option>
                  </el-select>
                  <span>{{ errors[0] }}</span>
                </ValidationProvider>
              </el-form-item>
              <el-form-item label="Shop Name">
                <el-input v-model="form_data.shop_name" disabled> </el-input>
              </el-form-item>
              <el-form-item label="Final Rate">
                <el-input v-model="form_data.final_rate" disabled></el-input>
              </el-form-item>
              <el-form-item label="Status*">
                <ValidationProvider
                  name="status"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <el-select
                    class="w-100"
                    v-model="form_data.status"
                    name="status"
                    filterable
                    placeholder
                  >
                    <el-option :value="3" :label="'Approved'"></el-option>
                    <el-option :value="4" :label="'Rejected'"></el-option>
                    <el-option :value="5" :label="'Pending'"></el-option>
                  </el-select>
                  <span>{{ errors[0] }}</span>
                </ValidationProvider>
              </el-form-item>
            </el-form>
            <el-table
              :data="ordercart"
              border
              show-summary
              v-if="ordercart.length > 0"
              style="width: 100%"
            >
              <el-table-column
                prop="products.categories.category_name"
                label="Category"
                width="180"
              >
              </el-table-column>
              <el-table-column
                prop="products.product_name"
                label="Product"
                width="180"
              >
              </el-table-column>
              <el-table-column prop="total_rate" label="Rate" width="180">
              </el-table-column>
              <el-table-column prop="quantity" label="Quantity" width="180">
                <template slot-scope="scope">
                  <el-input-number
                    v-model="scope.row.quantity"
                    :min="1"
                    :max="99"
                    size="small"
                     :disabled="editInput_disabled"
                  ></el-input-number>
                </template>
              </el-table-column>
              <el-table-column prop="Action" label="Action" min-width="180">
                <template slot-scope="scope">
                  <el-button
                    type="button"
                    @click="delete_productFromCart(scope.row._id)"
                    >Delete
                  </el-button>
                  <el-button
                    type="button"
                    @click="activeEditInput()"
                    
                    >Edit
                  </el-button>
                   <el-button
                    type="button"
                    @click="refreshQuantity(scope.row._id)"
                    >Refresh
                  </el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>

          <div class="col-xs-12 mt-20 text-right drawer-footer">
            <el-button @click="closeDialog()">Cancel</el-button>
            <el-button type="primary" :disabled="invalid" @click="submitForm()"
              >Add</el-button
            >
          </div>
        </ValidationObserver>
      </div>
    </transition>
    <div v-show="addFormVisible" @click="closeDialog()" class="drawer-bg"></div>
  </div>
</template>
<script>
export default {
  props: {
    editFormVisible: {
      required: true,
    },
    edit_id: {
      required: true,
    },
    getOrders: {
      required: true,
    },
    users: {
      required: true,
    },
    categories: {
      required: true,
    },
  },
  data() {
    
    return {
      pageName: "update Order",
      editInput_disabled:true,
      form_data: {
        user_id: "",
        shop_name: "",
        final_rate: "",
        status: "",
      },
      ordercart: [],
      cart: {
        product_id: "",
        category_id: "",
        rate: "",
        quantity: "",
        total_rate: "",
      },
    };
  },
  computed: {
     ordercart:function(){
            if(this.ordercart.length > 1)
            {
                this.delete_disabled=true;
            }
            } 
  },
  watch: {
    editFormVisible: function () {
      var app = this;
      if (app.edit_id) {
        app.$axios
          .get(
            "http://localhost/beta-fact/public/order/editViewOrder/" +
              app.edit_id
          )
          .then(function (response) {
            //console.log(response);
            app.form_data.user_id = response.data.user_id;
            app.form_data.shop_name = response.data.shops.shop_name;
            app.form_data.final_rate = response.data.final_rate;
            app.ordercart = response.data.orders;
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
  },
};
</script>