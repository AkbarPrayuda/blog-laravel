import { Link } from "react-router-dom";
import axios from "../Services/Axios";
import { useState } from "react";
import Swal from "sweetalert2";

const Register = () => {
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errors, setErrors] = useState([]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post("register", {
                name,
                email,
                password,
            });
            console.log(response);
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Berhasil register, silahkan login",
                showConfirmButton: false,
                timer: 2000,
            });
            window.location.href = "/";
        } catch (error) {
            setErrors(error.response.data.errors);
        }
    };

    return (
        <>
            <div className="min-h-screen hero bg-base-200">
                <div className="flex-col hero-content lg:flex-row-reverse lg:gap-10">
                    <div className="text-center lg:text-left">
                        <h1 className="text-5xl font-bold">
                            Silahkan Register!
                        </h1>
                        <p className="py-6">
                            Silahkan Register dan buat akun anda
                        </p>
                        <p>
                            Sudah ada akun? silahkan{" "}
                            <Link
                                to={"/"}
                                className="text-blue-500 hover:text-blue-600"
                            >
                                Login
                            </Link>{" "}
                            disini.
                        </p>
                    </div>
                    <div className="w-full max-w-sm shadow-2xl card shrink-0 bg-base-100">
                        <form className="card-body" onSubmit={handleSubmit}>
                            <div className="form-control">
                                <label className="label" htmlFor="name">
                                    <span className="label-text">Nama</span>
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    placeholder="Nama.."
                                    className="input input-bordered"
                                    onChange={(e) => setName(e.target.value)}
                                    autoFocus
                                />
                                {errors.name && (
                                    <label className="label-text-alt text-red-500">
                                        {errors.name}
                                    </label>
                                )}
                            </div>
                            <div className="form-control">
                                <label className="label" htmlFor="email">
                                    <span className="label-text">Email</span>
                                </label>
                                <input
                                    id="email"
                                    type="text"
                                    placeholder="email.."
                                    className="input input-bordered"
                                    onChange={(e) => setEmail(e.target.value)}
                                />
                                {errors.email && (
                                    <label className="label-text-alt text-red-500">
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
                                    placeholder="password.."
                                    className="input input-bordered"
                                    onChange={(e) =>
                                        setPassword(e.target.value)
                                    }
                                />
                                {errors.password && (
                                    <label className="label-text-alt text-red-500">
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

export default Register;
