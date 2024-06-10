import axios from "../Axios";

export const getUserProfile = async () => {
    const token = localStorage.getItem("auth_token");
    try {
        const response = await axios.get("user", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        return response.data.data;
    } catch (error) {
        console.log(error);
    }
};
