import VueRouter from "vue-router";
import Bookables from "./bookables/bookables";

const routes = [
    {
        path: "/",
        component: Bookables,
        name: "home"
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
