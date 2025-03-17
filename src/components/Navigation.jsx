import { gql, useQuery } from "@apollo/client";
import { NavLink } from "react-router-dom";
import styles from "./Navigation.module.css";

const GET_CATEGORIES = gql`
  query {
    categories {
      id
      name
    }
  }
`;

function Navigation() {
    const { loading, error, data } = useQuery(GET_CATEGORIES);

    if (loading) return <p>Loading...</p>;

    if (error) return <p>Error loading categories</p>;

    return (
        <nav>
            <ul className={styles.navList}>
                {data.categories.map((category) => (
                    <li key={category.id}>
                        <NavLink
                            to={`/${category.name.toLowerCase()}`} 
                            data-testid="category-link"
                            className={({ isActive }) => isActive ? styles.activeCategory : styles.navLink}
                            >
                            {category.name} 
                        </NavLink>
                    </li>
                ))}
            </ul>
        </nav>
    );
}

export default Navigation;