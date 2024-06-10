import React from "react";
import formatDate from "../Services/formatDate";
import { Link } from "react-router-dom";
import { TrashIcon } from "@heroicons/react/24/solid";
import { deletePost } from "../Services/api/posts";
import Swal from "sweetalert2";

const Card = (props) => {
    const handleDeletePost = async (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                deletePost(id);
            }
        });
    };

    return (
        <div className="border shadow-xl card md:w-80 lg:w-64 sm:w-96 bg-base-100 dark:border-stone-300">
            <figure className="relative">
                {props.delete ? (
                    <TrashIcon
                        className="bg-gray-600  absolute top-1 bg-opacity-20 hover:bg-opacity-40 text-red-400 cursor-pointer right-1 w-5 hover:text-red-500"
                        onClick={() => handleDeletePost(props.id)}
                    />
                ) : (
                    ""
                )}
                <img
                    src={`storage/` + props.image}
                    alt={props.title}
                    className="object-cover w-full lg:h-36 md:h-56 h-60"
                />
            </figure>
            <Link to={`/detail/${props.id}`}>
                <div className="px-3 py-4 text-sm">
                    <h2 className="text-base font-semibold">{props.title}</h2>
                    <p>{props.content.substring(0, 30)}..</p>
                    <p className="mt-4 text-xs font-semibold">
                        {props.created ? props.created : ""}
                    </p>
                    <p className="text-xs font-semibold">
                        {formatDate(props.created_at)}
                    </p>
                </div>
            </Link>
        </div>
    );
};

export default Card;
