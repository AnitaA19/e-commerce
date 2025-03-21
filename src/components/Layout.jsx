import { Outlet } from 'react-router-dom';
import Header from "./Header";
import CartOverlay from "./CartOverlay";
import { useCartContext } from "../contexts/CartContext";
import '../index.css';

function Layout() {
  const { isModalOpen } = useCartContext();
  
  return (
    <div>
      <Header />
        <Outlet />
      {isModalOpen && <CartOverlay />}
    </div>
  );
}

export default Layout;