--------------------Ayush chettante etho program--------------------<!--   * vue: "2.5.17",
* @package FACTFOKUZ
* @author  AYUSH
* @Date   04-01-2020
* @module Expense
* @prop from   Index
* Can Edit Expenses
* Description: Expense Edit
-->
<template>
  <div>
    <el-dialog title :visible="orderProductDeleteConfirm" :before-close="handleClose" width="40%">
      <span>Are you sure you want to delete Expense Category?</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="orderProductDeleteConfirm = false">Cancel</el-button>
        <el-button type="primary" @click="deleteExpenseCategory">Confirm</el-button>
      </span>
    </el-dialog>
    <transition name="drawer-transition">
      <div v-show="editExpenseDialouge" class="col-xs-12 col-md-9 col-lg-7 drawer-div">
        <div class="drawer-head">
          <div class="row">
            <h4 class="col-xs-10">Edit Expense</h4>
            <span class="col-xs-2">
              <a @click="closeDialog()" class="drawer-close-btn">X</a>
            </span>
          </div>
        </div>
        <ValidationObserver v-slot="{ invalid }" ref="form">
          <div class="popup-scroll">
            <el-form :model="expense" ref="Edit Expense" class="update-mrn-form">
              <el-form-item :label-width="formLabelWidth" class="col-sm-6 icon-input">
                <validation-provider rules="required" :name="$userLabel" v-slot="{ errors }">
                  <span class="input-icon el-icon-user"></span>
                  <label>Select {{ $userLabel }}</label>
                  <span class="required-star">*</span>
                  <el-select
                    class="w-100"
                    v-model="expense.user_id"
                    clearable
                    filterable
                    data-vv-delay="100"
                    :placeholder="$userLabel"
                  >
                    <el-option
                      class="demo-select-header"
                      v-for="user in users"
                      :key="user._id"
                      :label="user.name +' ('+ user.employee_id+') '"
                      :value="user._id"
                    ></el-option>
                  </el-select>
                  <span class="error" v-if="errors[0]">{{ errors[0] }}</span>
                </validation-provider>
              </el-form-item>
              <el-form-item :label-width="formLabelWidth" class="col-sm-6 icon-input">
                <validation-provider rules="required" name="date" v-slot="{ errors }">
                  <span class="input-icon icon-calendar-1"></span>
                  <label>Expense Date</label>
                  <span class="required-star">*</span>
                  <el-date-picker
                    v-model="expense.date"
                    type="date"
                    :picker-options="pickerOptions"
                    @change="datePicked"
                    placeholder="Expense Date"
                  ></el-date-picker>
                  <span class="error" v-if="errors[0]">{{ errors[0] }}</span>
                </validation-provider>
              </el-form-item>
              <el-form-item :label-width="formLabelWidth" class="col-sm-6 icon-input">
                <span class="input-icon icon-calendar-1"></span>
                <label>Status</label>
                <el-select
                  class="w-100"
                  v-model="expense.status"
                  name="status"
                  filterable
                  placeholder
                >
                  <el-option :value="3" :label="'Approved'"></el-option>
                  <el-option :value="4" :label="'Rejected'"></el-option>
                  <el-option :value="5" :label="'Pending'"></el-option>
                </el-select>
              </el-form-item>

              <!-- <el-form-item> -->
              <el-form-item :label-width="formLabelWidth" class="col-sm-6 icon-input mt-20">
                <label>Special Approval</label>
                <el-checkbox v-model="approval"></el-checkbox>
              </el-form-item>
              <el-form-item :label-width="formLabelWidth" class="col-xs-12 col-sm-12 icon-input">
                <span class="input-icon el-icon-tickets"></span>
                <label>Description</label>
                <el-input placeholder="Description" type="textarea" v-model="expense.description" clearable></el-input>
              </el-form-item>
              <el-form-item :label-width="formLabelWidth" class="col-xs-12 col-sm-12 icon-input">
                <span class="input-icon el-icon-edit-outline"></span>
                <label>Comment</label>
                <el-input placeholder="Comment" type="textarea" v-model="expense.comment" clearable></el-input>
              </el-form-item>
            </el-form>
            <ValidationObserver v-slot="{ subinvalid }" ref="subform">
              <div class="col-xs-12">
                <el-table ref="multipleTable" :data="expense_details" stripe>
                  <!-- :max-height="$window_format_height" -->
                  <el-table-column
                    min-width="230"
                    prop="expense_category.name"
                    sortable
                    label="Expense Category"
                  ></el-table-column>

                  <el-table-column min-width="200" v-if="$can('expense', 'action')" label="Amount">
                    <template slot-scope="routes">
                      <validation-provider
                        :rules="{ numeric:true , required:true, min_value:1 }"
                        :name="'rate'+routes.row._id"
                        v-slot="{ errors }"
                      >
                        <el-input-number
                          v-if="routes.row.edited"
                          :min="0"
                          :step="1"
                          step-strictly
                          placeholder="Amount"
                          v-model="routes.row.amount"
                          clearable
                        ></el-input-number>
                        <span v-if="!routes.row.edited">{{routes.row.amount}}</span>
                        <!-- <span
                      class="error error-class"
                      v-if="errors.has('rate'+routes.row._id)"
                        >Please enter valid amount.</span>-->
                        <span class="error" v-if="errors[0]">Please enter valid amount.</span>
                      </validation-provider>
                    </template>
                  </el-table-column>
                  <el-table-column min-width="230" prop="remark" sortable label="Remarks"></el-table-column>
                  <el-table-column
                    min-width="150"
                    v-if="expense_details.length>1"
                    prop="date"
                    label="Action"
                    fixed="right"
                  >
                    <template slot-scope="order_products">
                    <el-tooltip effect="light" content="Edit" placement="bottom" class="mr-5">
                      <a>
                        <i
                          class="el-icon-edit custom-icon edit-icon pointer"
                          @click="form_submit_disable = 0 ;editMrnProduct(order_products.$index)"
                          v-if="!order_products.row.edited"
                        ></i>
                      </a>
                      </el-tooltip>
                      <el-tooltip effect="light" content="Save" placement="bottom" class="mr-5">
                      <a>
                        <i
                          class="custom-icon details-icon el-icon-refresh pointer"
                          @click="form_submit_disable = 1 ;icon_flag=0;editExpenseDetails(order_products.row.amount,order_products.row._id,order_products.$index)"
                          v-if="order_products.row.edited"
                          :disabled="subinvalid"
                        ></i>
                      </a>
                      </el-tooltip>
                      <el-tooltip effect="light" content="Close" placement="bottom" class="mr-5">
                      <a>
                        <i
                          class="el-icon-circle-close-outline pointer"
                          @click="cancelEditMrnProduct;form_submit_disable = 1 ;"
                          v-if="order_products.row.edited"
                        ></i>
                      </a>
                      </el-tooltip>
                      <el-tooltip effect="light" content="Delete" placement="bottom">
                        <a
                          v-if="order_products.length != 1"
                          @click="deleteMrnProduct(order_products.$index)"
                          class="custom-icon delete-icon el-icon-delete pointer"
                        ></a>
                      </el-tooltip>
                      <!-- @click="deleteExpenseDetails(order_products.row._id)" -->
                    </template>
                  </el-table-column>
                  <el-table-column
                    min-width="150"
                    prop="date"
                    label="Action"
                    fixed="right"
                    align="center"
                    v-if="expense_details.length==1"
                  >
                    <template slot-scope="order_products">
                      <a>
                        <i
                          class="el-icon-edit custom-icon edit-icon pointer"
                          @click="editMrnProduct(order_products.$index)"
                          v-if="!order_products.row.edited"
                        ></i>
                      </a>
                      <a>
                        <i
                          class="custom-icon details-icon el-icon-refresh pointer"
                          @click="icon_flag=0;editExpenseDetails(order_products.row.amount,order_products.row._id,order_products.$index)"
                          v-if="order_products.row.edited"
                          :disabled="subinvalid"
                        ></i>
                      </a>
                      <a>
                        <i
                          class="el-icon-circle-close-outline pointer"
                          @click="cancelEditMrnProduct;form_submit_disable = 1 ;"
                          v-if="order_products.row.edited"
                        ></i>
                      </a>
                    </template>
                  </el-table-column>
                </el-table>
              </div>
            </ValidationObserver>
          </div>
          <div class="col-xs-12 mt-20 text-right drawer-footer">
            <el-button @click="closeDialog()" round>Cancel</el-button>
            <el-button
              type="primary"
              :disabled=" !isEditComplete || form_submit_disable == 0 || imageSize > 10000000"
              @click="submitForm()"
            >Update</el-button>
          </div>
        </ValidationObserver>
      </div>
    </transition>

    <transition name="drawer-transition">
      <div v-show="editExpenseDialouge" @click="closeDialog()" class="drawer-bg"></div>
    </transition>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      loading: false,
      formLabelWidth: "100px",
      categories: "",
      edit_category: {
        _id: "",
        name: "",
        user_id: ""
      },
      icon_flag: 0,
      form_submit_disable: 1,
      expenses: "",
      expense: {},
      expense_details: [],
      expenseId: [],
      approvals: "",
      approval: "",
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      },
      expenseCategory_id: "",
      travelCategory: 0,
      imageSize: "",
      showImage: false,
      showDownload: false,
      error: "",
      image: [],
      organization_id: "",
      url: "",
      editindex: "",
      file: "",
      type: "",
      expense_id: "",
      fileName: "",
      orderProductDeleteConfirm: false,
      deleteIndex: "",
      options: [
        {
          value: "3",
          label: "Approved"
        },
        {
          value: "4",
          label: "Rejected"
        },
        {
          value: "5",
          label: "Pending"
        }
      ]
    };
  },
  mounted() {
    var app = this;

    //Get all expenses Categories ------------------------//
    axios
      .get(app.$hostname + "/expense/get_expense_category")
      .then(function(resp) {
        app.categories = resp.data;
      })
      .catch(function(resp) {
        app.$message({
          message: "Could not load Expense Categories.",
          type: "error"
        });
      });
    //end of Get all expense Categories -----------------//
  },
  props: {
    editExpenseDialouge: {
      required: true
    },
    getResultsPage: {
      required: true
    },
    currentPage: {
      required: true
    },
    expenseEditId: {
      required: true
    },
    users: {
      required: true
    }
  },
  watch: {
    approvals: function(val) {
      var app = this;
      /* var val = app.approvals === "true"; */
      if (app.approvals == "true" || app.approvals == "True") {
        app.approval = true;
      } else {
        app.approval = false;
      }
    },
    editExpenseDialouge: function(val) {
      var app = this;
      if ((val = true)) {
        /* app.getUpdateForm(); */
      }
    },
    expenseEditId: function() {
      var app = this;

      if (app.expenseEditId) {
        app.loading = true;
        axios
          .post(app.$hostname + "/expense/get_expense_details", {
            id: this.expenseEditId
          })
          .then(function(response) {
            if (
              typeof response.data.expense.image != "undefined" &&
              response.data.expense.image != "" &&
              response.data.image == "true"
            ) {
              // app.image = {};
              app.showImage = false;
              app.showDownload = true;
            } else {
              app.showImage = true;
              app.showDownload = false;
            }

            app.expenses = response.data;
            app.expense = response.data.expense;

            app.category_id = response.data.expense.category_id;
            app.file = response.data.expense.file;
            app.image = response.data.expense.image;
            app.expense_id = response.data.expense._id;
            app.approvals = response.data.expense.special_approval;
            app.organization_id = response.data.expense.organization_id;
            app.expense_details = response.data.expense_details;
            app.url =
              app.$hostname +
              "/uploads/" +
              app.organization_id +
              "/expense/" +
              app.expense.image;
            app.loading = false;
            if (app.approvals == "true" || app.approvals == "True") {
              app.approval = true;
            } else {
              app.approval = false;
            }
          });
      }
      // app.loading = false;
    },
    image: function() {
      var app = this;
      app.type = typeof app.image;
      /* console.log(typeof app.image); */
    }
  },
  methods: {
    deleteMrnProduct(index) {
      this.deleteIndex = index;
      this.orderProductDeleteConfirm = true;
    },
    getSummaries(param) {
      const { columns, data } = param;
      const sums = [];
      columns.forEach((column, index) => {
        if (index === 0) {
          sums[index] = "Total Amount";
          return;
        }
        if (index === 1) {
          console.log(data);
          const values = data.map(item => Number(item[column.property]));
          console.log(values);
          if (!values.every(value => isNaN(value))) {
            sums[index] =
              this.$allSessionData.currency_symbol +
              values.reduce((prev, curr) => {
                const value = Number(curr);
                if (!isNaN(value)) {
                  return prev + curr;
                } else {
                  return prev;
                }
              }, 0);
          } else {
            sums[index] = "N/A";
          }
        } else {
          sums[index] = "";
        }
      });
      return sums;
    },

    deleteExpenseCategory() {
      var app = this;
      var id = app.expense_details[app.deleteIndex]._id;
      var expense_id = app.expense_details[app.deleteIndex].expense_id;

      axios
        .post(
          app.$hostname +
            "/expense/delete_view_details?expense_id=" +
            expense_id +
            "&id=" +
            id
        )
        .then(function(response) {
          if (response.data == "Success") {
            app.loading = true;
            axios
              .post(app.$hostname + "/expense/get_expense_details", {
                id: app.expenseEditId
              })
              .then(function(response) {
                if (
                  typeof response.data.expense.image != "undefined" &&
                  response.data.expense.image != "" &&
                  response.data.image == "true"
                ) {
                  // app.image = {};
                  app.showImage = false;
                  app.showDownload = true;
                } else {
                  app.showImage = true;
                  app.showDownload = false;
                }

                app.expenses = response.data;
                app.expense = response.data.expense;
                app.getResultsPage(app.currentPage);
                app.category_id = response.data.expense.category_id;
                app.file = response.data.expense.file;
                app.image = response.data.expense.image;
                app.expense_id = response.data.expense._id;
                app.approvals = response.data.expense.special_approval;
                app.organization_id = response.data.expense.organization_id;
                app.expense_details = response.data.expense_details;
                app.url =
                  app.$hostname +
                  "/uploads/" +
                  app.organization_id +
                  "/expense/" +
                  app.expense.image;
                app.loading = false;
                if (app.approvals == "true" || app.approvals == "True") {
                  app.approval = true;
                } else {
                  app.approval = false;
                }
              });
            app.orderProductDeleteConfirm = false;
          }
        });
    },
    handleClose() {
      this.orderProductDeleteConfirm = false;
    },
    //------edit mrn product-----------------//
    editMrnProduct(index) {
      var app = this;

      var editindex = app.editindex;
      if (app.expense_details[editindex] !== undefined) {
        app.expense_details[editindex].edited = false;
      }
      app.expense_details[index].edited = true;
      app.editindex = index;
    },
    //------end of edit mrn product----------//
    //------cancel function for mrn product--------//
    cancelEditMrnProduct() {
      var app = this;
      app.expense_details[app.editindex].edited = false;
    },
    //------end of cancel function for mrn product-//
    editExpenseDetails(amount, id, index) {
      var app = this;
      if (amount > 0) {
        app.expense_details[index].edited = false;
        axios
          .get(
            app.$hostname +
              "/expense/edit_expense_amount?expense_id=" +
              app.expense_id +
              "&id=" +
              id +
              "&amount=" +
              amount
          )
          .then(function(resp) {
            app.getResultsPage(app.currentPage);
            app.$message({
              message: "Amount Edited successfully.",
              type: "success"
            });
          })
          .catch(function(resp) {
            app.$message({
              message: "Could not edit amount.",
              type: "error"
            });
          });
        app.icon_flag = 0;
      } else {
        app.icon_flag = 1;
      }
    },
    datePicked() {
      if (this.expense.date) {
        this.expense.date = this.$moment(this.expense.date).format(
          "YYYY-MM-DD"
        );
      }
    },
    handleFileUpload() {
      // console.log(333);

      var allowed_types = ["jpg", "jpeg", "bmp", "gif", "png"];
      var extention = this.$refs.file.files[0].name.split(".").pop();
      if (allowed_types.includes(extention)) {
        this.image = this.$refs.file.files[0];
        this.imageSize = this.image.size;
        this.url = URL.createObjectURL(this.image);
      } else {
        this.$message({
          message: "Select image to upload.",
          type: "error"
        });
      }
      if (
        typeof this.image != "undefined" &&
        this.image != ""
        //  &&
        // this.image == "true"
      ) {
        // console.log(111);
        this.showImage = false;
        this.showDownload = true;
        // console.log(this.showDownload);
        // console.log(this.showImage);
      } else {
        this.showImage = true;
        this.showDownload = false;
        // console.log(444);
      }
    },
    handleFileUploadz() {
      this.image = this.$refs.file.files[0];
      this.url = URL.createObjectURL(this.image);
      /* this.image.name = null; */
    },
    handleFileUploads() {
      /* this.expense.file = this.$refs.file.files[0]; */
      this.file = this.$refs.file.files[0];
      this.imageSize = this.image.size;
      this.fileName = "";
    },
    closeDialog() {
      var app = this;
      app.expenses = {};
      app.expense = {};
      app.expenseCategory_id = "";
      app.file = "";
      app.image = "";
      app.approvals = false;
      app.organization_id = "";
      app.$refs.form.reset();
      app.$emit("update:expenseEditId", null);
      app.$emit("update:editExpenseDialouge", false);
    },
    submitForm() {
      var app = this;
      if (this.form_submit_disable != 0) {
        let formData = new FormData();
        formData.append("file", app.image);
        formData.append("image", app.image);
        formData.append("user_id", app.expense.user_id);
        formData.append("_id", app.expense._id);
        formData.append("amount", app.expense.amount);
        formData.append("category_id", app.expense.category_id);
        formData.append("date", app.expense.date);
        formData.append("status", app.expense.status);
        formData.append("title", app.expense.title);
        formData.append("startKm", app.expense.startKm);
        formData.append("endKm", app.expense.endKm);
        formData.append("comment", app.expense.comment);
        formData.append("description", app.expense.description);
        formData.append("special_approval", app.approval);
        axios
          .post(app.$hostname + "/expense/expense_edit", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(function(response) {
            if (response.data == "Success") {
              app.getResultsPage(app.currentPage);
              app.$message({
                message: "Expense Edited successfully.",
                type: "success"
              });
              app.form_submit_disable = 1;
              app.$refs.form.reset();
            }
          });

        /* ); */
      }
    }
  },

  computed: {
    isEditComplete() {
      return this.expense.user_id && this.expense.date && this.expense.status;
    }
  }
};
</script>