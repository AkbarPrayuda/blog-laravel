import { useEffect, useState } from "react";
import Navbar from "../Components/Navbar";
import Footer from "../Components/Footer";
import Card from "../Elements/Card";
import { getUserProfile } from "../Services/api/user";
import { getPostsUser, postStore } from "../Services/api/posts";

const Dashboard = () => {
    const [button, setbutton] = useState("Upload");
    const [title, setTitle] = useState("");
    const [content, setContent] = useState("");
    const [image, setImage] = useState("");
    const [user, setUser] = useState([]);
    const [error, setError] = useState([]);
    const [posts, setPosts] = useState([]);

    const changeButton = () => {
        setbutton(button == "Upload" ? "Dashboard" : "Upload");
    };

    const handleImageChange = (e) => {
        setImage(e.target.files[0]);
    };

    const handleSubmit = (e) => {
        e.preventDefault;

        const data = new FormData();
        data.append("title", title);
        data.append("content", content);
        data.append("image", image);
        data.append("user_id", user.id);

        postStore(data).then((res) => setError(res));
    };

    useEffect(() => {
        const token = localStorage.getItem("auth_token");
        if (!token) {
            location.href = "/";
        }
        getUserProfile().then((i) => setUser(i));
    }, []);

    useEffect(() => {
        const response = getPostsUser()
            .then((res) => setPosts(res.data.data))
            .catch((err) => console.log(err));
    }, []);

    return (
        <>
            <div className="h-screen ">
                <Navbar />
                <header className="shadow-lg">
                    <div className="flex items-center justify-between px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <h1 className="text-3xl font-bold tracking-tight light:text-gray-900">
                            {button == "Upload" ? "Dashboard" : "Upload"}
                        </h1>
                        <button
                            className="text-white btn btn-success dark:btn-accent btn-sm"
                            onClick={changeButton}
                        >
                            {button}
                        </button>
                    </div>
                </header>
                <main>
                    <div className="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div className={button === "Upload" ? "hidden" : ""}>
                            <form>
                                <div className="flex flex-col py-2">
                                    <label htmlFor="title">Judul</label>
                                    <input
                                        id="title"
                                        type="text"
                                        name="title"
                                        className="input input-sm input-bordered"
                                        placeholder="Judul.."
                                        onChange={(e) =>
                                            setTitle(e.target.value)
                                        }
                                    />
                                    {error.title && (
                                        <p className="text-sm text-red-500">
                                            {error.title}
                                        </p>
                                    )}
                                </div>
                                <div className="flex flex-col py-2">
                                    <label htmlFor="content">Deskripsi</label>
                                    <textarea
                                        id="content"
                                        className="textarea textarea-bordered"
                                        placeholder="Deskripsi Postingan.."
                                        onChange={(e) =>
                                            setContent(e.target.value)
                                        }
                                    ></textarea>
                                    {error.content && (
                                        <p className="text-sm text-red-500">
                                            {error.content}
                                        </p>
                                    )}
                                </div>
                                <div className="flex flex-col py-2">
                                    <label htmlFor="image">Sampul</label>
                                    <input
                                        id="image"
                                        type="file"
                                        className="w-full max-w-xs file-input file-input-bordered"
                                        name="image"
                                        onChange={handleImageChange}
                                    />
                                </div>
                                <button
                                    className="text-white btn btn-success dark:btn-accent"
                                    type="button"
                                    onClick={handleSubmit}
                                >
                                    Upload
                                </button>
                            </form>
                        </div>
                        <div className={button === "Dashboard" ? "hidden" : ""}>
                            <div className="flex flex-col flex-wrap justify-center gap-8 px-6 md:px-16 md:flex-row md:justify-around">
                                {posts.map((data, i) => (
                                    <Card
                                        key={i}
                                        title={data.title}
                                        content={data.content}
                                        image={
                                            data.image_path
                                                ? data.image_path
                                                : "images/image.png"
                                        }
                                        created_at={data.created_at}
                                        id={data.id}
                                        delete={true}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </main>
                <Footer />
            </div>
        </>
    );
};

export default Dashboard;
