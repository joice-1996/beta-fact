<!--   * vue: "2.5.17",
* @package FACTFOKUZ
* @author  AYUSH
* @Date   04-01-2020
* @module Leave Category
* @prop from   Index
* Can Add Leave Category
* Description: Leave Category Add
-->
<template>
  <div>
    <transition name="drawer-transition">
      <div v-show="addFormVisible" class="col-xs-12 col-md-4 col-lg-3 drawer-div">
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
              <el-form-item :label-width="formLabelWidth" class="col-xs-12 input-item icon-input">
                <validation-provider rules="required" name="Leave Category" v-slot="{ errors }">
                  <span class="input-icon icon-calendar-1"></span>
                  <label>
                    Leave Category
                    <span class="required-star">*</span>
                  </label>
                  <el-input
                    placeholder="Category"
                    name="Leave Category"
                    v-model="form_data.category_name"
                    @input="check_target()"
                    clearable
                    ref="focus_field"
                  ></el-input>
                  <span class="error" v-if="errors[0]">{{ errors[0] }}</span>
                </validation-provider>
              </el-form-item>
            </el-form>
          </div>
          <div class="col-xs-12 mt-20 text-right drawer-footer">
            <el-button @click="closeDialog()">Cancel</el-button>
            <el-button
              type="primary"
              :disabled="invalid || !isEditComplete || form_submit_disable==0"
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
      pageName: "Add Leave Category",
      formLabelWidth: "100px",
      form_data: {
        category_name: ""
      },
      form_submit_disable: 0,
      form_check_disable: 0,
      value: ""
    };
  },
  props: {
    addFormVisible: {
      required: true
    },
  },
  methods: {
    closeDialog() {
      var app = this;
      app.$refs.form.reset();
      app.form_data.category_name = "";
      app.$emit("update:addFormVisible", false);
    },
    clearAll() {
      var app = this;
      app.form_data.category_name = "";
      app.$refs.form.reset();
    },
    submitForm() {
      var app = this;
      var form = this.form_data;
      axios
        .post(app.$hostname + "/master/add_leave_category", {
          data: form
        })
        .then(function(response) {
          if (response.data == "Success") {
            app.getResultsPage(app.currentPage);
            app.$message({
              message: "Leave Category Added Successfully.",
              type: "success"
            });
            app.form_data.category_name = "";
            app.$refs.form.reset();
          } else if (response.data == "Exist") {
            app.$message({
              message: "Leave Category Already Exists.",
              type: "warning"
            });
          }
        })
        .catch(function(resp) {
          app.$message({
            message: "Could not add Category.",
            type: "error"
          });
        });
    }
  },

  computed: {
    isEditComplete() {
      return this.form_data.category_name;
    }
  }
};
</script>

