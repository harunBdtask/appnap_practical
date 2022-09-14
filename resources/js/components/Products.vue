<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h3>Products List</h3>
            </div>
            <div class="col-sm-2">
                <router-link to="/store" class="nav-item nav-link btn btn-secondary text-white">Add product</router-link>
            </div>
        </div>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.title }}</td>
                <td>{{ product.category }}</td>
                <td>{{ product.price }}</td>
                <td style="max-width: 100px;">
                    <img 
                        v-if="product.document_path"
                        alt="Image"
                        style="border-radius: 5%; width: 30%;"
                        :src="product.document_path"
                    />
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'store', params: { id: product.id }}" class="btn btn-primary">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                products: []
            }
        },
        created() {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data;
                });
        },
        methods: {
            deleteProduct(id) {
                axios.delete(`/api/product/delete/${id}`)
                    .then(response => {
                        let i = this.products.map(item => item.id).indexOf(id); 
                        this.products.splice(i, 1)
                    });
            }
        }
    }
</script>