import { useCartContext } from '../contexts/CartContext';
import styles from './Cart.module.css';
import CartSVG from './CartSVG';

function Cart() {
    const { isModalOpen, setIsModalOpen, getTotalItems } = useCartContext();
    const itemCount = getTotalItems();
    
    const toggleCart = () => {
        setIsModalOpen(!isModalOpen);
    };
    
    return (
        <button className={styles.cartContainer} onClick={toggleCart} data-testid='cart-btn'>
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