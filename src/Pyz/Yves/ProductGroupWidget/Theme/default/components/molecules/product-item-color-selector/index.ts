import './product-item-color-selector.scss';
import register from 'ShopUi/app/registry';
export default register('product-item-color-selector', () => import(/* webpackMode: "lazy" */'ProductGroupWidget/components/molecules/product-item-color-selector/product-item-color-selector'));
