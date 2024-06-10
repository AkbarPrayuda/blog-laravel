import React, { Suspense, useEffect, useState } from "react";
import Navbar from "../Components/Navbar";
import Skeleton from "../Elements/Skeleton";
import { getAllPosts } from "../Services/api/posts";

const Card = React.lazy(() => import("../Elements/Card"));

const Home = () => {
    const [posts, setPosts] = useState([]);

    useEffect(() => {
        getAllPosts()
            .then((res) => setPosts(res))
            .catch((err) => console.log(err));
    }, []);

    return (
        <>
            <Navbar />
            <p className="py-20 text-4xl text-center ">
                Telusuri cerita dan bagikan pengalaman terbaik anda!
            </p>
            <div className="flex flex-col flex-wrap justify-center gap-8 px-6 md:px-16 md:flex-row md:justify-around">
                {posts.map((data, i) => (
                    <Suspense key={i} fallback={<Skeleton />}>
                        <Card
                            key={i}
                            id={data.id}
                            title={data.title}
                            image={
                                data.image_path
                                    ? data.image_path
                                    : "images/image.png"
                            }
                            content={data.content}
                            created_at={data.created_at}
                            created={data.user.name}
                        />
                    </Suspense>
                ))}
            </div>
        </>
    );
};

export default Home;
