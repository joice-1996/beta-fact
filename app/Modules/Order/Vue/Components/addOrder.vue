<!--   * vue: "2.5.17",
* @package BETAFACT
* @author  JOICE
* @Date   22-06-2021
* @module Order
* @prop from   Index
* Can Add Leave Category
* Description: Order Add
-->
<template>
  <div>
    <transition name="drawer-transition">
      <div v-show="addOrderFormVisible" class="col-xs-12 col-md-4 col-lg-3 drawer-div">
        <div class="drawer-head">
          <div class="row">
            <h4 class="col-xs-10">{{ pageName }}</h4>
            <span class="col-xs-2">
              <a @click="closeDialog()" class="drawer-close-btn">X</a>
            </span>
          </div>
        </div>
        <ValidationObserver v-slot="{ invalid }" ref="form">
        <div class="popup-scroll">
            <el-form :model="form_data" ref="Add Form">
                 <el-form-item label="Select User*">
            <ValidationProvider
              name="User"
              rules="required"
              v-slot="{ errors }"
            >
              <el-select v-model="form_data.user_id" clearable placeholder="Select">
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
                <el-form-item label="Select District*">
            <ValidationProvider
              name="district"
              rules="required"
              v-slot="{ errors }"
            >
              <el-select v-model="form_data.district_id" clearable placeholder="Select" @change="getShops()">
                <el-option
                  v-for="val in districts"
                  :key="val._id"
                  :label="val.distrcit_name"
                  :value="val._id"
                >
                </el-option>
              </el-select>
              <span color="red">{{ errors[0] }}</span>
            </ValidationProvider>
          </el-form-item>
             <el-form-item label="Select Shop*">
            <ValidationProvider
              name="shop"
              rules="required"
              v-slot="{ errors }"
            >
              <el-select v-model="form_data.shop_id" clearable placeholder="Select">
                <el-option
                  v-for="val in shops"
                  :key="val._id"
                  :label="val.shop_name"
                  :value="val._id"
                >
                </el-option>
              </el-select>
              <span>{{ errors[0] }}</span>
            </ValidationProvider>
          </el-form-item>
          <el-form-item label="Remarks">
            <ValidationProvider
              name="remark"
              rules="alpha"
              v-slot="{ errors }"
            >
              <el-input
                v-model="form_data.remark"
                placeholder="Enter any remarks"
              ></el-input>
              <span>{{ errors[0] }}</span>
            </ValidationProvider>
          </el-form-item>
           <div id="cart">
            <ValidationObserver>
              <el-form>
                  <el-form-item label="Select Category*">
                  <ValidationProvider
                    name="category"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <el-select
                      v-model="cart.category_id"
                      clearable
                      placeholder="Select Category"
                      @change="getProducts()"
                    >
                      <el-option
                        v-for="val in categories"
                        :key="val._id"
                        :label="val.category_name"
                        :value="val._id"
                      >
                      </el-option>
                    </el-select>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </el-form-item>
                <el-form-item label="Select Product*">
                  <ValidationProvider
                    name="product"
                    rules="required"
                    v-slot="{ errors }"
                  >
                    <el-select
                      v-model="cart.product_id"
                      clearable
                      placeholder="Select"
                      @change="getProductRate()"
                    >
                      <el-option
                        v-for="val in products"
                        :key="val._id"
                        :label="val.product_name"
                        :value="val._id"
                      >
                      </el-option>
                    </el-select>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </el-form-item>
               
                
                <el-form-item label="rate*">
                  <ValidationProvider
                    name="rate"
                    rules="required|numeric"
                    v-slot="{ errors }"
                  >
                    <el-input
                      type="input"
                      disabled
                      v-model="cart.rate"
                      placeholder="Rate of the product"
                      @input="getTotalRate()"
                    ></el-input>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </el-form-item>
                <el-form-item label="Quantity*">
                  <ValidationProvider
                    name="quantity"
                    rules="required|numeric"
                    v-slot="{ errors }"
                  >
                    <el-input
                      type="input"
                      v-model="cart.quantity"
                      placeholder="Enter quantity"
                       @input="getTotalRate()"
                    ></el-input>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </el-form-item>
                <el-form-item label="Total*">
                  <ValidationProvider
                    name="total"
                    rules="required|numeric"
                    v-slot="{ errors }"
                  >
                    <el-input
                      type="input"
                      disabled
                      v-model="cart.total_rate"
                      placeholder="Total Rate"
                    ></el-input>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </el-form-item>
                <el-form-item>
                <el-tooltip content="Add" placement="bottom" effect="light">
                    <el-button @click="addTempCart()"  class="el-icon-plus custom-btn add-btn"></el-button>
                </el-tooltip>
                </el-form-item>
              </el-form>
            </ValidationObserver>
          </div>
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
              <el-table-column
              
              prop="products.rate"
              label="Rate"
              width="180"
            >
            </el-table-column>
              <el-table-column
              prop="quantity"
              label="Quantity"
              width="180"
            >
           
          
            </el-table-column>
            <el-table-column prop="Action" label="Action" min-width="180">
              <template slot-scope="scope">
                <el-button
                  type="button"
                  @click="delete_productFromCart(scope.row._id)"
                  >Delete
                </el-button>
              </template>
            </el-table-column>
          </el-table>
          </div>
         
          <div class="col-xs-12 mt-20 text-right drawer-footer">
            <el-button @click="closeDialog()">Cancel</el-button>
            <el-button
              type="primary"
              :disabled="invalid"
              @click="submitForm()"
            >Add</el-button>
          </div>
        </ValidationObserver>
      </div>
    </transition>
    <div v-show="addFormVisible" @click="closeDialog()" class="drawer-bg"></div>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      loading: false,
      pageName: "Add Order",
      formLabelWidth: "100px",
      ordercart:[],
      products:[],
      shops:[],
      form_data: {
        user_id: "",
        district_id:'',
        shop_id:'',
        remarks:''
      },
      cart:{
          product_id:'',
          category_id:'',
          rate:'',
          quantity:'',
          total_rate:''
      },
     // form_submit_disable: true,
      form_check_disable: 0,
      value: ""
    };
  },
  props: {
    addOrderFormVisible: {
      required: true
    },
    users:{
        required:true
    },
    districts:{
        required:true
    },
    categories:{
        required:true
    }
  },
  mounted(){
      this.deleteFullCart()
  },
  methods: {
    closeDialog() {
      var app = this;
      app.$refs.form.reset();
      app.form_data.category_name = "";
      app.$emit("update:addOrderFormVisible", false);
    },
    clearAll() {
      var app = this;
      app.form_data.category_name = "";
      app.$refs.form.reset();
    },

    getShops(){
        var app=this
        let district=app.form_data.district_id;
        //console.log(district)
        app.$axios.get('http://localhost/beta-fact/public/order/getShops/'+district)
                    .then(response=>(
                        app.shops=response.data
                    ))
                    .catch(error=>{
                    app.$message({
                        message:"List cannot be loaded",
                        type:error
                    });
                    })
    },
    getProducts(){
        var app=this
        let category=app.cart.category_id;
        //console.log(category)
        app.$axios.get('http://localhost/beta-fact/public/order/getProducts/'+category)
                    .then(response=>(
                        app.products=response.data
                    ))
                    .catch(error=>{
                    app.$message({
                        message:"List cannot be loaded",
                        type:error
                    });
                    })
    },
    getProductRate(){
        var app=this
        let product=app.cart.product_id
        console.log(product)
        app.$axios.get('http://localhost/beta-fact/public/order/getProductRate/'+product)
                    .then(response=>(
                        app.cart.rate=response.data.rate
                    ))
                    .catch(error=>{
                    app.$message({
                        message:"Rate not get",
                        type:error
                    });
                    })
    },
    getTotalRate()
    {

        var app=this
        let product_rate=app.cart.rate
        let product_quantity=app.cart.quantity
        app.cart.total_rate=product_rate * product_quantity
        
    },
    deleteFullCart()
    {
        var app=this
          app.$axios.get('http://localhost/beta-fact/public/order/deleteFullCart')
                    .then(response=>(
                        console.log(response)
                    ))
                    

    },
    addTempCart(){
        var app=this
         app.$axios
        .post("http://localhost/beta-fact/public/order/addTempCart", app.cart)
        .then(function (response) {
          console.log(response);
          if(response.data.trim()=="required_error")
          {
              app.$message({
              message: "All the fields are required",
              type: "warning",
            });
          }
          else if(response.data.trim()=="exist")
          {
            
              app.$message({
              message: "Product already exist",
              type: "warning",
            });
          }
          else if (response.data.trim() == "success") {
            app.$message({
              message: "successfully saved",
              type: "success",
            });
            app.cart= {
                product_id: "",
                category_id: "",
                rate: "",
                quantity: "",
                total_rate: "",
            }
            app.$refs.form.reset();
            app.getOrderCart();
           // app.form_submit_disable=false
          }
        });
    },
    getOrderCart()
    {
        var app=this
        app.$axios.get('http://localhost/beta-fact/public/order/getOrderCart')
                    .then(response=>(
                        app.ordercart=response.data
                    ))
                    .catch(error=>{
                    app.$message({
                        message:"List cannot be loaded",
                        type:error
                    });
                    })

    },
    delete_productFromCart(id)
    {
        var app=this
         app.$axios
        .get("http://localhost/beta-fact/public/order/delete_productFromCart/"+ id)
        .then(function (response) {
          console.log(response);
          if(response.data.trim()=="success")
          {
              app.$message({
              message: "successfully deleted",
              type: "success",
            });
            app.getOrderCart();
          }
        }
        )
    },
    submitForm(){
      var app = this;
      app.$axios
        .post("http://localhost/beta-fact/public/order/saveOrder", app.form_data)
        .then(function (response) {
          console.log(response);
          if (response.data.trim() == "success") {
            app.$message({
              message: "successfully saved",
              type: "success",
            });
            
          }
        });

    }
  },

  computed: {
    /*  form_submit_disable:function()
    {
        if(ordercart.length > 0)
        {
          this.form_submit_disable = false
        }
        else
        {
          this.form_submit_disable = true
        }
        
    }  */
  }
};
</script>
<style scoped>
    #cart {
    border: 1px solid red;
    padding: 10px;
}
</style>

