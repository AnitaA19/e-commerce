import { useCartContext } from '../contexts/CartContext';
import styles from './Cart.module.css';
import CartSVG from './CartSVG';

function Cart() {
    const { setIsModalOpen, getTotalItems } = useCartContext();
    const itemCount = getTotalItems();
    
    return (
        <button className={styles.cartContainer} onClick={() => setIsModalOpen(true)} data-testid='cart-btn'>
          <CartSVG/>
            
            {itemCount > 0 && (
                <div className={styles.cartBadge}>
                    <span>{itemCount}</span>
                </div>
            )}
        </button>
    );
}

export default Cart;