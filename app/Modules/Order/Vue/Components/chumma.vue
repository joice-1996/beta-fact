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
              <el-table-column prop="products.rate" label="Rate" width="180">
              </el-table-column>
              <el-table-column prop="quantity" label="Quantity" width="180">
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