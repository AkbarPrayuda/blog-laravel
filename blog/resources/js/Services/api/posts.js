import Swal from "sweetalert2";
import axios from "../Axios";

export const postStore = async (data) => {
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.post(`posts`, data, {
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "multipart/form-data",
            },
        });
        await Swal.fire({
            position: "top-end",
            icon: "success",
            title: response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });
        location.href = "/dashboard";
    } catch (error) {
        return error.response.data.errors;
    }
};

export const getAllPosts = async () => {
    try {
        // await new Promise((resolve) => setTimeout(resolve, 2000));
        const token = localStorage.getItem("auth_token"); // Ambil token dari localStorage
        if (!token) {
            window.location.href = "/";
        }

        const response = await axios.get("/posts", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        return response.data.data;
    } catch (error) {
        return error.response.data.message;
    }
};

export const getPostById = async (data) => {
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.get(`posts/${data}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export const getPostsUser = async () => {
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.get("user/posts", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        return response;
    } catch (err) {
        console.log(err);
    }
};

export const deletePost = async (id) => {
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.post(
            `posts/${id}/delete`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
        });
        location.href = "/dashboard";
    } catch (error) {
        console.log(error);
    }
};
