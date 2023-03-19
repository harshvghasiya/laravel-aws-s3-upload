<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Models\FileMan;
use App\Models\RightModule;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\FileManRequest;

class FileController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            $this->user = \Auth::user();
            if (CHECK_RIGHTS_TO_ACCESS_DENIED(RightModule::CONST_CONTACT_SETTING, $this->user
            ) )
            {
                return $next($request);
            }
            else
            {
                $succ_msg = trans('message.you_do_not_have_access');
                flashMessage('error',$succ_msg);
                return redirect()->route('admin.dashboard');
            }
        
        }); 
        $this->Model=new FileMan;
    }

    public function index(Request $request)
    {
        $title = 'Folders'; 

        $folders = \App\Models\Folder::with(['self_sub_folder', 'self_folder'])->doesnthave('self_folder')->where('user_id', \Auth::user()->id)->get();  

        $files = \App\Models\FileMan::where('folder_id', null)->get();

        return view('admin::file.index', compact('title', 'folders', 'files'));
    }

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ],[
            'name.required' => 'Folder Name is required'
        ]);

        $res = new \App\Models\Folder;
        $res->name = $request->name;
        $res->user_id = \Auth::user()->id;
        $res->save();

        $msg = 'Folder Added successfully';

        $url = route('admin.file.index');

        flashMessage('success', $msg);
        
        return response()->json([ 'msg' => $msg, 'url' => $url, 'status' => true ]);

    }

    public function storeSubFolder(Request $request)
    {
        $parent_id = $request->parent_id;

        $request->validate([
            'sub_folder_name' => 'required'
        ],[
            'sub_folder_name.required' => 'Folder Name is required'
        ]);

        $res = new \App\Models\Folder;
        $res->name = $request->sub_folder_name;
        $res->user_id = \Auth::user()->id;
        $res->save();

        $re = new \App\Models\SubFolder;
        $re->folder_id = $res->id;
        $re->parent_id = $parent_id;
        $re->user_id = \Auth::user()->id;
        $re->save();

        $msg = 'Folder Added successfully';

        $url = route('admin.file.add_sub_folder', $parent_id);

        flashMessage('success', $msg);
        
        return response()->json([ 'msg' => $msg, 'url' => $url, 'status' => true ]);
    }

    public function storeSubFile(Request $request)
    {
        $parent_id = $request->parent_id;

        $request->validate([
            'sub_file_name' => 'required'
        ],[
            'sub_file_name.required' => 'File is required'
        ]);

        $res = new \App\Models\FileMan;
        $res->folder_id = $parent_id;
        $res->user_id = \Auth::user()->id;
        $name=time().$request->sub_file_name->getClientOriginalName();

        $res->name = $name;
        $path = \Storage::disk('s3')->put( $name, file_get_contents($request->sub_file_name));
        $path = \Storage::disk('s3')->url($path); 

        $res->save();

        $msg = 'File Added successfully';

        $url = route('admin.file.add_sub_folder', $parent_id);

        flashMessage('success', $msg);
        
        return response()->json([ 'msg' => $msg, 'url' => $url, 'status' => true ]);
    }

    public function addSubFolder(Request $request)
    {
        $parent_id = $request->parent_id;

        $title = '';
        $folders =  \App\Models\Folder::with(['self_sub_folder', 'self_folder'])->whereHas('self_folder', function ($query) use($parent_id)
        {
            $query->where('parent_id', $parent_id);

        })->where('user_id', \Auth::user()->id)->get();

        $files = \App\Models\FileMan::where('folder_id', $parent_id)->get();

        return view('admin::file.add_sub_folder', compact('parent_id', 'title', 'folders', 'files'));
    }

    public function storeFile(Request $request)
    {
        $request->validate([

            'file_name' => 'required'
        ],[

            'file_name.required' => 'File Name is required'
        ]);

        $res = new \App\Models\FileMan;
        $res->name = $request->file_name;
        $res->user_id = \Auth::user()->id;

        $name=time().$request->file_name->getClientOriginalName();
        $res->name = $name;
        $path = \Storage::disk('s3')->put( $name, file_get_contents($request->file_name));
        $path = \Storage::disk('s3')->url($path); 

        $res->save();

        $msg = 'File saved successfully';

        $url = route('admin.file.index');

        return response()->json([ 'msg' => $msg, 'url' => $url, 'status' => true]);
    }

    public function deleteFile(Request $request)
    {
        
        $file_id = $request->id;

        $file = \App\Models\FileMan::where('id', $file_id)->first();

        if ( $file == null ) {
            
            return response()->json([ 'msg' => 'File Not found', 'status' => 2]);
        }

        $file_name = $file->name;
        \Storage::disk('s3')->delete($file_name);
        $file->delete();

        return response()->json([ 'msg' => 'File deleted successfully', 'status' => 1]);
    }

    public function deleteFolder(Request $request)
    {
        
        $id = $request->id;

        

        


        return response()->json([ 'msg' => 'File deleted successfully', 'status' => 1]);

    }

     


}
