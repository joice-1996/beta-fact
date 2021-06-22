<!-- 
Recent Activity
created by :MORFIN PAUL
Date : 08/10/2018
-->
<template>
    <div v-loading="loading">
         <div class="login-container">
        <div class="col-xs-12 col-md-5 login-left hidden-xs hidden-sm">
                <img :src="$hostname + '/images/sf-logo.svg'" width="220" alt="Salesfokuz" class="" />
                <h5>
                    A customizable dealer management software <br> to deliver right
                    orders at the right place and <br> time at the tap of a button.
                </h5>


            </div>

        <div class="col-xs-12 col-md-7 col-xs-12 login-right">
            <div class="col-xs-11 col-sm-6 col-md-7 col-lg-6 login-field float-none m-auto">
                <div class="login-field-inner">
                     <h3>Login</h3>
                    <div class="login-field-inner-mob">
                      
                        <ValidationObserver v-slot="{ invalid }">
                            <el-form :model="formData" ref="addForm">
                                <div class="form-group mb-20" id="username_div">
                                    <el-form-item>
                                        <validation-provider rules="required|email" name="email" v-slot="{ errors }">
                                            <input type="text" class="form-control" placeholder="Email Address" autocomplete="off" v-model="formData.email" />
                                            <span class="error" v-if="errors[0]">{{ errors[0] }}</span>
                                        </validation-provider>
                                    </el-form-item>
                                </div>
                                <div class="form-group mb-20" id="password_div" v-if="!forgot_password">
                                    <el-form-item>
                                        <validation-provider rules="required" name="password" v-slot="{ errors }">
                                            <input type="password" class="form-control" placeholder="Password" v-model="formData.password" autocomplete="off" />
                                            <span class="error" v-if="errors[0]">{{ errors[0] }}</span>
                                        </validation-provider>
                                    </el-form-item>
                                </div>
                                <button type="submit" class="login-btn" value="Sign In" @click="loginPost" :disabled="invalid || !isComplete" v-if="!forgot_password">Sign In</button>

                                <button type="submit" class="login-btn" value="Reset Password" @click="resetPassword" :disabled="invalid || !isforgotComplete" v-if="forgot_password">Reset Password</button>
                            </el-form>
                        </ValidationObserver>
                        <div class="col-xs-12 text-center">
                            <a class="forgot-password"  v-if="!forgot_password" @click="forgot_password = true" data-toggle="tab">Forgot Password?</a>
                            <a class="forgot-password"  v-if="forgot_password" @click="forgot_password = false" data-toggle="tab">Login</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="login-social-media col-xs-12 mt-20">
                    <a href="https://www.facebook.com/salesfokuz" target="_blank" class="icon icon-facebook1"></a>
                    <a href="https://twitter.com/salesfokuz" target="_blank" class="icon icon-twitter"></a>
                    <a href="https://vimeo.com/salesfokuz" target="_blank" class="icon icon-vimeo"></a>
                    <a href="https://in.linkedin.com/company/salesfokuz" target="_blank" class="icon icon-linkedin"></a>
                    <a href="https://www.youtube.com/c/Salesfokuz" target="_blank" class="icon icon-youtube"></a>
                </div>
        </div>
             
    </div>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                formData: {
                    email: "",
                    password: ""
                },
                forgot_password: false,
                loading: false
            };
        },
        methods: {
            //Get Recent Activity-----------------------//
            loginPost(e) {
                e.preventDefault();
                var app = this;
                axios
                    .post(app.$hostname + "/post-login", {
                        email: app.formData.email,
                        password: (app.formData.password)
                        // password: app.formData.password
                    })
                    .then(
                        function(response) {
                            if (response.data.msg == "success") {
                                app.$router.push({
                                    name: "dashboard",                                
                                });
                            } else {
                                app.$message({
                                    message: "Sorry. Invalid credentials",
                                    type: "error"
                                });
                            }
                        },
                        function errorCallback(response) {
                            app.$message({
                                message: "Sorry. Invalid credentials",
                                type: "error"
                            });
                        }
                    );
            },
        },
        computed: {
            isComplete() {
                return this.formData.email && this.formData.password;
            },
            isforgotComplete() {
                return this.formData.email;
            }
        }
    };

</script>
