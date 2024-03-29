import VueRouter from "vue-router";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";
import Review from './review/Review.vue';
import ShoppingCart from "./checkout/ShoppingCart";

const routes = [
    {
        path: "/auth/login",
        component: require('./auth/Login').default,
        name: "login"
    },
    {
        path: "/auth/register",
        component: require('./auth/Register').default,
        name: "register"
    },
    {
        path: "/",
        component: Bookables,
        name: "home"
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable.show"
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review"
    },
    {
        path: "/order/cart",
        component: ShoppingCart,
        name: "shopping-cart"
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
