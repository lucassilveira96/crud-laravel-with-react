// ** Type import
import { VerticalNavItemsType } from 'src/@core/layouts/types'

const navigation = (): VerticalNavItemsType => {
  return [
    {
      title: 'Home',
      path: '/home',
      icon: 'bx:home-circle',
    },
    {
      title: 'Produtos',
      path: '/products/list',
      icon: 'bx:package',
    },
    {
      title: 'Categorias',
      path: '/product-categories/list',
      icon: 'bx:layer',
    },
    {
      path: '/acl',
      action: 'read',
      subject: 'acl-page',
      title: 'Access Control',
      icon: 'bx:shield',
    }
  ]
}

export default navigation
