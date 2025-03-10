// Layout.js - Updated to include CartModal
import { Outlet } from 'react-router-dom';
import Header from "./Header";
import CartModal from "./CartModal";
import { useCartContext } from "../contexts/CartContext";
import '../index.css';

function Layout() {
  const { isModalOpen } = useCartContext();
  
  return (
    <div>
      <Header />
      <div>
        <Outlet />
      </div>
      {isModalOpen && <CartModal />}
    </div>
  );
}

export default Layout;