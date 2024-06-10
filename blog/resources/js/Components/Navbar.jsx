import axios from "../Services/Axios";
import Toggle from "../Elements/Toggle";
import { Link } from "react-router-dom";

const Navbar = () => {
    const logout = async () => {
        const token = localStorage.getItem("auth_token");
        try {
            response = await axios.post("/logout", {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
        } catch (error) {
            console.log(error);
        }
        localStorage.clear();
        location.href = "/";
    };
    return (
        <>
            <div className=" navbar bg-base-100">
                <div className="navbar-start">
                    <div className="dropdown">
                        <div
                            tabIndex={0}
                            role="button"
                            className="btn btn-ghost btn-circle"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M4 6h16M4 12h16M4 18h7"
                                />
                            </svg>
                        </div>
                        <ul
                            tabIndex={0}
                            className="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
                        >
                            <li>
                                <Link to="/home">Beranda</Link>
                            </li>
                            <li>
                                <Link to="/dashboard">Dashboard</Link>
                            </li>
                            <li>
                                <a onClick={logout}>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="navbar-center">
                    <a className="text-xl btn btn-ghost">Blog</a>
                </div>
                <div className="navbar-end">
                    <Toggle />
                </div>
            </div>
        </>
    );
};

export default Navbar;
