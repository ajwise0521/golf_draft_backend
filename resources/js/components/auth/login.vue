<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-8">
	            <div class="card">
	                <div class="card-header">Login</div>

	                <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" v-model="email" type="email" class="form-control" name="email" required>

                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-6">
                                <input v-model="password" id="password" type="password" class="form-control" name="password" required>

                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button v-on:click="login" class="btn btn-primary">
                                   Login
                                </button>
                                    <a class="btn btn-link" href="">
                                    	Forget Your Password?
                                    </a>
                            </div>
                        </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>
<script>
    module.exports = {
        data: function () {
            return {
                loginFailed: false,
                email: '',
                password: '',
            };
        },
        methods: {
            login: function () {
                axios.post('/login', {
                    email: this.email,
                    password: this.password,
                })
                    .then((response) => {
                        vueStore.commit('auth/authenticate', response.data);

                        this.$router.replace('/');
                    })
                    .catch((error) => {
                        this.loginFailed = true;
                    });
            },
            credentialsModified: function () {
                this.loginFailed = false;
            }
        },
    }
</script>
