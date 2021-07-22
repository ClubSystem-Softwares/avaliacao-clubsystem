<template>
    <div class = "container">
        <h4 class="text-center">Editar Produto</h4>
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" class="form-control" v-model="product.descricao">
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="text" class="form-control" v-model="product.valor">
                    </div>
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="text" class="form-control" v-model="product.quantidade">
                    </div>
                    <button type="submit" class="btn btn-primary confirm">Atualizar</button>
                </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            product: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/products/edit/${this.$route.params.id}`)
                .then(response => {
                    this.product = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateProduct() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/products/update/${this.$route.params.id}`, this.product)
                    .then(response => {
                        this.$router.push({name: 'products'});
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
