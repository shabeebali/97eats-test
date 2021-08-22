
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') },
      {
        path: 'restaurants',
        component: () => import('pages/Restaurants.vue'),
        children: [
          { path: '', component: () => import('pages/Restaurants/Index.vue') },
          { path: 'create', component: () => import('pages/Restaurants/Create.vue') },
          { path: 'edit/:id', component: () => import('pages/Restaurants/Create.vue') },
          { path: 'view/:id', component: () => import('pages/Restaurants/View.vue') }
        ]
      }
    ]
  },
  { path: '/login', component: () => import('pages/Login.vue'), name: 'LoginPage' },
  { path: '/register', component: () => import('pages/Register.vue'), name: 'RegisterPage' },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
