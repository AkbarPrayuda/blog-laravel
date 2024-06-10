import { Link } from "react-router-dom";
import Navbar from "../Components/Navbar";

const NotFound = () => {
    return (
        <>
            <Navbar />
            <div className="flex flex-col items-center justify-center h-screen ">
                <h1 className="text-6xl font-semibold text-red-500">
                    Not Found..
                </h1>
                <Link
                    className="text-xl font-semibold text-blue-500 underline hover:text-blue-700"
                    to="/home"
                >
                    Back to home..
                </Link>
            </div>
        </>
    );
};

export default NotFound;
