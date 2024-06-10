import React, { useEffect } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import "../css/app.css";
import Register from "./pages/Register";
import Home from "./pages/Home";
import Login from "./pages/Login";
import UserProfile from "./Components/UserProfile";
import Dashboard from "./pages/Dashboard";
import DetailPosts from "./pages/DetailPosts";
import NotFound from "./pages/NotFound";

const App = () => {
    return (
        <>
            <Router>
                <Routes>
                    <Route path="/" element={<Login />} />
                    <Route path="/dashboard" element={<Dashboard />} />
                    <Route path="/home" element={<Home />} />
                    <Route path="/register" element={<Register />} />
                    <Route path="/profile" element={<UserProfile />} />
                    <Route path="/detail/:id" element={<DetailPosts />} />
                    <Route path="*" element={<NotFound />} />
                    {/* Rute lain */}
                </Routes>
            </Router>
        </>
    );
};

const container = document.getElementById("app");
const root = createRoot(container);
root.render(<App />);
