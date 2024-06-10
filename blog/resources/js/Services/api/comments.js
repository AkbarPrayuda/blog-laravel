import Swal from "sweetalert2";
import axios from "../Axios";

export const storeComment = async (data) => {
    // const response = await axios.post(`comment/${data}`, data);
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.post(
            `comment/${data.post_id}`,
            {
                user_id: data.user_id,
                content: data.content,
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        await Swal.fire({
            position: "top-end",
            icon: "success",
            title: response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });
        location.reload();
        return response.data;
    } catch (error) {
        return error.response.data;
    }
};

export const deleteComment = async (id) => {
    const token = localStorage.getItem("auth_token");

    try {
        const response = await axios.post(
            `comment/${id}/delete`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        await Swal.fire({
            position: "top-end",
            icon: "success",
            title: response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });
        return response;
    } catch (error) {
        console.log(error);
    }
};
