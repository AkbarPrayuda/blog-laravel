import { Link } from "react-router-dom";
import axios from "../Services/Axios";
import { useEffect, useState } from "react";
import Swal from "sweetalert2";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errors, setErrors] = useState([]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post("login", { email, password });
            console.log(response);
            localStorage.setItem("auth_token", response.data.token);
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500,
            });
            location.href = "/home";
        } catch (error) {
            if (!error.response.data.errors) {
                await Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: error.response.data.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
                to = "/";
            }
            setErrors(error.response.data.errors);
        }
    };

    return (
        <>
            <div className="min-h-screen hero bg-base-200">
                <div className="flex-col hero-content lg:flex-row-reverse lg:gap-10">
                    <div className="text-center lg:text-left">
                        <h1 className="text-5xl font-bold">Silahkan Login!</h1>
                        <p className="py-6">
                            Selamat datang, silahkan Login untuk masuk!
                        </p>
                        <p>
                            Jika Belum memiliki akun, silahkan{" "}
                            <Link
                                to={"/register"}
                                className="text-blue-500 hover:text-blue-600"
                            >
                                Register
                            </Link>{" "}
                            terlebih dahulu.
                        </p>
                    </div>
                    <div className="w-full max-w-sm shadow-2xl card shrink-0 bg-base-100">
                        <form className="card-body" onSubmit={handleSubmit}>
                            <div className="form-control">
                                <label className="label" htmlFor="email">
                                    <span className="label-text">Email</span>
                                </label>
                                <input
                                    id="email"
                                    type="text"
                                    placeholder="email"
                                    className="input input-bordered"
                                    onChange={(e) => setEmail(e.target.value)}
                                    autoFocus
                                />
                                {errors.email && (
                                    <label className="text-red-500 label-text-alt">
                                        {errors.email}
                                    </label>
                                )}
                            </div>
                            <div className="form-control">
                                <label className="label" htmlFor="password">
                                    <span className="label-text">Password</span>
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    placeholder="password"
                                    className="input input-bordered"
                                    onChange={(e) =>
                                        setPassword(e.target.value)
                                    }
                                />
                                {errors.password && (
                                    <label className="text-red-500 label-text-alt">
                                        {errors.password}
                                    </label>
                                )}
                            </div>
                            <div className="mt-6 form-control">
                                <button className="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Login;
