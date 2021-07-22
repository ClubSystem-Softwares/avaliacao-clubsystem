<template>
  <div class="container productList">
    <h4 class="text-center">Listagem de produtos</h4>
    <br />
    <div id="blockHeader">
      <label for="range">Produtos por página </label>
      <select class="select" v-model="range" @change="handlePagination(page)">
        <option value= 5 selected>5</option>
        <option value= 25>25</option>
        <option value= 50>50</option>
        <option value= 100>100</option>
      </select>
      <button
        type="button"
        class="btn btn-primary add-btn"
        @click="this.$router.push('/products/add')"
      >
        Adicionar produto
      </button>
    </div>

    <div class="tableWrapper">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Quantidade</th>
            <th>Data de criação</th>
            <th>Última edição</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in products.slice(this.limitDown, this.limitUp)"
            :key="product.id"
          >
            <td>{{ product.id }}</td>
            <td>{{ product.descricao }}</td>
            <td>{{ product.valor }}</td>
            <td>{{ product.quantidade }}</td>
            <td>{{ product.created_at }}</td>
            <td>{{ product.updated_at }}</td>
            <td>
              <div class="btn-group" role="group">
                <router-link
                  :to="{ name: 'editproduct', params: { id: product.id } }"
                  class="btn btn-primary"
                  >Editar
                </router-link>
                <button
                  class="btn btn-danger"
                  @click="deleteProduct(product.id)"
                >
                  Deletar
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="blockFooter">
      <pagination
        v-model="page"
        :records="this.products.length"
        :per-page="this.range"
        @paginate="handlePagination"
        :options = "{ chunk: 10, texts: {
            count: ''
        }}"

      />
    </div>
  </div>
</template>

<script>
import Pagination from "v-pagination-3";

export default {
  data() {
    return {
      products: [],
      limitUp: 5,
      limitDown: 0,
      page: 1,
      range: 5,
    };
  },
  components: {
    Pagination,
  },
  created() {
    this.$axios.get("/sanctum/csrf-cookie").then((response) => {
      this.$axios
        .get("/api/products")
        .then((response) => {
          this.products = response.data;
        })
        .catch(function (error) {
          console.error(error);
        });
    });
  },
  methods: {
    handlePagination(page) {
      this.limitDown = this.range * (page - 1);
      this.limitUp = this.range * page;
    },
    deleteProduct(id) {
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .delete(`/api/products/delete/${id}`)
          .then((response) => {
            let i = this.products.map((item) => item.id).indexOf(id); // Achar o id do produto
            this.products.splice(i, 1);
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
  beforeRouteEnter(to, from, next) {
    if (!window.Laravel.isLoggedin) {
      window.location.href = "/";
    }
    next();
  },
};
</script>
