<script setup>
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();

const form = useForm({ username: "", email: "", password: "" });
const page = usePage();

function submit() {
    if (form.username.length === 0) {
        toaster.error("Name is required");
        return;
    } else if (form.email.length === 0) {
        toaster.error("Email is required");
        return;
    } else if (form.password.length === 0) {
        toaster.error("Password is required");
        return;
    } else {
        form.post(route("register"), {
            preserveState: true,
            onSuccess: () => {
                router.push("/");
                toaster.success("Registration successful");
            },
            onError: (errors) => {
                if (errors.username) {
                    toaster.error(errors.username[0]);
                } else if (errors.email) {
                    toaster.error(errors.email[0]);
                } else if (errors.password) {
                    toaster.error(errors.password[0]);
                }
            },
        });
    }
}
</script>

<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.username"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="form.email"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    v-model="form.password"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    >Confirm Password</label
                                >
                                <input type="password" class="form-control" />
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
