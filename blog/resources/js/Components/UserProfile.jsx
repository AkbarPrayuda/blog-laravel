import axios from "../Services/Axios";
import React, { useState, useEffect } from "react";
import Navbar from "./Navbar";

function UserProfile() {
    useEffect(() => {
        const getUser = async () => {
            const token = localStorage.getItem("auth_token");
            const response = await axios.get("user", {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            console.log(response);
        };
        getUser();
    }, []);

    return (
        <>
            <Navbar />
            <div className="flex items-center justify-center h-96 ">
                <div className="w-4/6 shadow-xl card card-side bg-base-100">
                    <figure>
                        <img
                            src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.jpg"
                            alt="Movie"
                        />
                    </figure>
                    <div className="card-body">
                        <h2 className="card-title">New movie is released!</h2>
                        <p>Click the button to watch on Jetflix app.</p>
                        <div className="justify-end card-actions">
                            <button className="btn btn-primary">Watch</button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default UserProfile;
